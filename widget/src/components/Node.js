import React from 'react';
import NodeField from './NodeField.js';

class Node extends React.Component {
  constructor(props) {
    super(props);
  }


  render() {

    var fields = [];

    if(this.props.settings.directoryDisplaySchema){
      for (var field in this.props.settings.directoryDisplaySchema) {
        if (this.props.settings.directoryDisplaySchema.hasOwnProperty(field)) {
          fields.push(
            <NodeField
            field={field}
            value={this.props.nodeData[field]}
            attribs = {this.props.settings.directoryDisplaySchema[field]}
            nodeData = {this.props.nodeData}
            />
          )

        }
      }
    }

    return(
      <div className={"directory-node"}>
      {fields}
      </div>
    );
  }
}

export default Node
