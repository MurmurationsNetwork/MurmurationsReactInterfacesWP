import React from 'react';
import ReactPaginate from 'react-paginate'
import Node from './Node.jsx';

class Directory extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      activePage : 1
    };
  }

  nodesPerPage = 10

  handlePageClick = data => {
    this.setState({
      activePage: data.selected
    });
  }

  splitIntoPages = nodes => {
    return nodes.reduce((resultArray, node, index) => {
      const pageIndex = Math.floor(index / this.nodesPerPage)

      if (!resultArray[pageIndex]) {
        resultArray[pageIndex] = []
      }

      resultArray[pageIndex].push(node)

      return resultArray
    }, [])
  }

  render() {

    const nodes = this.props.nodes;

    return (
      <div>
        <div className="nodeList">
          <div className="node-count">{nodes.length} results found</div>
          {nodes.map((node) =>  <Node nodeData={node} />)}
        </div>
        <ReactPaginate
          previousLabel={'prev'}
          nextLabel={'next'}
          breakLabel={'...'}
          breakClassName={'break-me'}
          pageCount={nodes.length}
          marginPagesDisplayed={2}
          pageRangeDisplayed={5}
          onPageChange={this.handlePageClick}
          containerClassName={'pagination'}
          subContainerClassName={'pages pagination'}
          activeClassName={'active'}
        />
      </div>
    );

  }
}

export default Directory
