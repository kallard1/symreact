import {combineReducers} from 'redux';

import categoryReducer from './categoryReducer';
import errorReducer from './errorReducer';

export default combineReducers({
  categories: categoryReducer,
  error: errorReducer,
});
