import {CLEAR_ERRORS, GET_ERRORS} from '../actions/types';

const initialState = {
  msg: {},
  status: null,
  id: null,
};

export default (state = initialState, action) => {
  switch (action.type) {
    case CLEAR_ERRORS:
      return {
        msg: {},
        status: null,
        id: null,
      };
    case GET_ERRORS:
      const {msg, status, id} = action.payload;

      return {
        msg, status, id,
      };
    default:
      return state;
  }
};
