import React from 'react';
import NodeField from './NodeField.js';

class Node extends React.Component {
  constructor(props) {
    super(props);
  }


  render() {

    var node_content = [];

    if(this.props.settings.apiNodeFormat == 'HTML'){
      node_content = <div dangerouslySetInnerHTML={{ __html: this.props.nodeData }} />
    }else if(this.props.settings.directoryDisplaySchema){
      for (var field in this.props.settings.directoryDisplaySchema) {
        if (this.props.settings.directoryDisplaySchema.hasOwnProperty(field)) {
          node_content.push(
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
      {node_content}
      </div>
    );
  }
}

export default Node
