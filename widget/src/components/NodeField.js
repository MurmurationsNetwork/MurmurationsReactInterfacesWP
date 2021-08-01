import React from 'react';

class NodeField extends React.Component {
  constructor(props) {
    super(props);
  }
  
  render() {

    if(!this.props.value){
      return null;
    }

    if(this.props.value === Object(this.props.value) && !Array.isArray(this.props.value)){
      return null;
    }

    var value = this.props.value;

    const { field, attribs, nodeData } = this.props;

    if(Array.isArray(value)){
      value = value.join(", ");
    }

    var labelElement = '';
    if(attribs.showLabel == true){
      var labelValue = attribs.label;
      labelElement = <div className={"node-field-label "+field}>{labelValue}</div>
    }else{
      labelElement = '';
    }

    if(attribs.truncate){
      if (value.length > attribs.truncate){
        value = value.slice(0, attribs.truncate) + '...'
      }
    }

    if(attribs.link){
      value = <a href={nodeData[attribs.link]}>{value}</a>
    }

    return(
      <div className={"node-field "+field}>
        {labelElement}
        <div className={"node-field-value "+field}>
        {value}
        </div>
      </div>
    );
  }
}

export default NodeField
