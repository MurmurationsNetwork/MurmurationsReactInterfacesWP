import React from 'react';
import Form from "@rjsf/core";
import Directory from './Directory.js';
import Map from './Map.js';

class MurmurationsInterface extends React.Component {

  constructor(props) {
    super(props);
    this.fetchNodes = this.fetchNodes.bind(this);
    this.handleFilterSubmit = this.handleFilterSubmit.bind(this);
    this.handleSearchSubmit = this.handleSearchSubmit.bind(this);
    this.handleSearchChange = this.handleSearchChange.bind(this);
    this.state = {
      nodes: [],
      filterFormData : props.settings.formData
    };

  }

  fetchNodes(filters){
    var api_url = this.props.settings.apiUrl;
    var api_node_format = this.props.settings.apiNodeFormat;

    this.setState({isLoaded : false});

    var params = new URLSearchParams(filters);

    params.set('format', api_node_format);

    if(this.state.search){
      params.set('search', this.state.search);
    }

    fetch(api_url+'?'+params.toString())
      .then(res => res.json())
      .then(
        (result) => {
          this.setState({
            isLoaded: true,
            nodes: result
          });
        },
        (error) => {
          this.setState({
            isLoaded: true,
            error
          });
        }
      )


  }

  handleSearchChange(event) {
    this.setState({search : event.target.value});
  }

  handleSearchSubmit(event) {
    event.preventDefault();
    this.fetchNodes();
  }

  handleFilterSubmit({formData}, e) {

    var filters = "";

    this.setState({filterFormData : formData});

    Object.keys(formData).forEach((key,index) => {
      if(formData[key]){
        if (formData[key] != "any" && formData[key] != ""){
          if('operator' in this.props.settings.filterSchema.properties[key]){
            var op = this.props.settings.filterSchema.properties[key].operator;
          }else{
            var op = 'equals';
          }
          filters += "filters["+index+"][0]="+key+'&';
          filters += "filters["+index+"][1]="+op+"&";
          filters += "filters["+index+"][2]="+formData[key]+"&";
        }
      }
    });

    this.fetchNodes(filters);

  }

  componentDidMount() {

    this.fetchNodes();

  }

  render() {

    const schema = this.props.settings.filterSchema;

    const { error, isLoaded, nodes } = this.state;

    var interfaceComponent;

    if (error) {
      interfaceComponent = <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      interfaceComponent = <div>Loading...</div>;
    } else {
      if (this.props.interfaceComp == 'directory' ){
        interfaceComponent = <Directory nodes={nodes} settings={this.props.settings} />
      } else if (this.props.interfaceComp == 'map' ){
        interfaceComponent = <Map nodes={nodes} settings={this.props.settings} />
      }
    }

      return (
        <div>
          <div className="mri-filter-form">
            <Form schema={schema}
            formData={this.state.filterFormData}
            onChange={this.handleFilterSubmit}
            onError={console.log("errors", this)} />
          </div>
          <div className="mri-search-form">
            <form action="/" onSubmit={this.handleSearchSubmit} >
              <input type="text" name="search"  onChange={this.handleSearchChange} value={this.state.search} />
              <button type="submit">Search</button>
            </form>
          </div>
          {interfaceComponent}
        </div>
      );

  }
}

export default MurmurationsInterface
