import React from 'react';

class Node extends React.Component {
  constructor(props) {
    super(props);
    this.state = {date: new Date()};
  }
  render() {
    return(
      <div>
        <h3 className="nodeTitle">
        {this.props.nodeData.name}
        </h3>
        <div className="nodeDesc">
        {this.props.nodeData.country}
        </div>

      </div>
    );
  }
}

export default Node
