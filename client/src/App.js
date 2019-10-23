import React from 'react';
import {BrowserRouter, Route} from 'react-router-dom';

import AppFrontend from './layouts/AppFrontend';
import AppBackend from './layouts/AppBackend';

import HomePage from './pages/HomePage';
import Dashboard from './pages/admin/Dashboard';

function App() {
  return (
    <BrowserRouter>
      <Route exact path="/"
             render={() => <AppFrontend><HomePage/></AppFrontend>}/>
      <Route exact path="/admin/"
             render={() => <AppBackend><Dashboard/></AppBackend>}/>
    </BrowserRouter>
  );
}

export default App;
