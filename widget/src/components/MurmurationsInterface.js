import React from 'react';
import Form from "@rjsf/core";
import Directory from './Directory.js';
import Map from './Map.js';

class MurmurationsInterface extends React.Component {

  constructor(props) {
    super(props);
    this.fetchNodes = this.fetchNodes.bind(this);
    this.handleFilterSubmit = this.handleFilterSubmit.bind(this);
    this.state = {
      nodes: [],
      filterFormData : {}
    };
  }

  fetchNodes(filters){
    var api_url = window.wpReactSettings.apiUrl;

    console.log("Fetching nodes from "+api_url);

    this.setState({isLoaded : false});

    //var filters = new URLSearchParams(filters);

    fetch(api_url+'?'+filters)
      .then(res => res.json())
      .then(
        (result) => {
          console.log("Result" + result);
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

  handleFilterSubmit({formData}, e) {

    var filters = "";

    this.setState({filterFormData : formData});

    Object.keys(formData).forEach(function(key,index) {
      if('operator' in window.wpReactSettings.filterSchema.properties[key]){
        var op = window.wpReactSettings.filterSchema.properties[key].operator;
      }else{
        var op = 'equals';
      }
      filters += "filters["+index+"][0]="+key+'&';
      filters += "filters["+index+"][1]="+op+"&";
      filters += "filters["+index+"][2]="+formData[key]+"&";
    });

    console.log(filters);

    this.fetchNodes(filters);

  }

  componentDidMount() {

    this.setState({filterFormData : window.wpReactSettings.formData});

    fetch(window.wpReactSettings.apiUrl)
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

  render() {

    const schema = window.wpReactSettings.filterSchema;

    const { error, isLoaded, nodes } = this.state;

    const log = (type) => console.log.bind(console, type);

    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      log(schema)
      log(nodes)
      log(this.filterFormData)
      return (
        <div>
          <Form schema={schema}
          formData={this.filterFormData}
          //onChange={log("changed")}
          onSubmit={this.handleFilterSubmit}
          //onSubmit={this.handleFilterSubmit}
          onError={log("errors")} />
          <Directory nodes={nodes} />

        </div>
      );
    }
  }
}

export default MurmurationsInterface
