import http from '../../services/http';

export const state = {

};

export const getters = {

};

export const mutations = {

};

export const actions = {
  fetchAssets() {
    return http.get('/assets')
      .then(res => res.data)
      .then((res) => {
        console.log(res);
      });
  },
};
