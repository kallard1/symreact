import React, {Component} from 'react';
import {bindActionCreators} from 'redux';
import {connect} from 'react-redux';

import {getCategories} from '../actions/categoryAction';

class HomePage extends Component {

  componentDidMount() {
    this.props.getCategories();
  }

  render() {
    return (
      <div>

      </div>
    );
  }
}

const mapStateToProps = ({categories}) => ({
  categories
});

const mapDispatchToProps = dispatch => bindActionCreators({
  getCategories
}, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(HomePage);
