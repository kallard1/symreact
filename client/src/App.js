import React from 'react';
import {BrowserRouter, Route} from 'react-router-dom';
import {library} from '@fortawesome/fontawesome-svg-core';
import {fab} from '@fortawesome/free-brands-svg-icons';
import {fad} from '@fortawesome/pro-duotone-svg-icons';
import {fal} from '@fortawesome/pro-light-svg-icons';
import {far} from '@fortawesome/pro-regular-svg-icons';
import {fas} from '@fortawesome/pro-solid-svg-icons';

import AppFrontend from './layouts/AppFrontend';
import AppBackend from './layouts/AppBackend';

import HomePage from './pages/HomePage';
import Dashboard from './pages/admin/Dashboard';

library.add(fad, fab, fal, far, fas);

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
