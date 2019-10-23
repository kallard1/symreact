import axios from 'axios';

import {GET_CATEGORY, LOADING} from './types';

/**
 * Get all categories
 *
 * @returns {Function}
 */
export const getCategories = () => (dispatch) => {
  dispatch({type: LOADING});

  axios
    .get('/api/categories')
    .then(res => {
      dispatch({
        type: GET_CATEGORY,
        payload: res.data["hydra:member"],
      });
    });
};

export const addCategory = () => {};

export const editCategory = () => {};

export const deleteCategory = () => {};
