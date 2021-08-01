import React from 'react';
import ReactPaginate from 'react-paginate'
import Node from './Node.js';

class Directory extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      activePage : 0,
      pageNodes: this.getPageNodes(0)
    };
  }

  nodesPerPage = this.props.nodesPerPage || 3

  handlePageClick = data => {
    this.setState({
      activePage: data.selected,
      pageNodes: this.getPageNodes(data.selected)
    });
  }

  getPageNodes = page => {
    const start = page*this.nodesPerPage;
    const end = start+this.nodesPerPage;
    return this.props.nodes.slice(start,end);
  }
/*
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
*/
  render() {

    const nodes = this.props.nodes;

    const pageNodes = this.state.pageNodes;

    return (
      <div>
        <div className="nodeList">
          <div className="node-count">{nodes.length} results found</div>
          {pageNodes.map((node) =>  <Node nodeData={node} />)}
        </div>
        <div className="react-paginate">
          <ReactPaginate
            previousLabel={'prev'}
            nextLabel={'next'}
            breakLabel={'...'}
            breakClassName={'break-me'}
            pageCount={nodes.length/this.nodesPerPage}
            marginPagesDisplayed={2}
            pageRangeDisplayed={3}
            onPageChange={this.handlePageClick}
            containerClassName={'pagination'}
            subContainerClassName={'pages pagination'}
            pageClassName={'page-link-li'}
            activeClassName={'active'}
          />
        </div>
      </div>
    );

  }
}

export default Directory
