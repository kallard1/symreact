import {
  ADD_CATEGORY,
  DELETE_CATEGORY,
  EDIT_CATEGORY,
  GET_CATEGORY,
  LOADING,
} from '../actions/types';

const initialState = {
  categories: [],
  loading: false,
};

export default function(state = initialState, action) {
  switch (action.type) {
    case ADD_CATEGORY:
      return {};
    case DELETE_CATEGORY:
      return {};
    case EDIT_CATEGORY:
      return {};
    case GET_CATEGORY:
      return {
        ...state,
        categories: action.payload,
        loading: false,
      };
    case LOADING:
      return {
        ...state,
        loading: true,
      };
    default:
      return state;
  }
};
