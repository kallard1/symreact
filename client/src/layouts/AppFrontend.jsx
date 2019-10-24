import React from 'react';
import {Container} from 'reactstrap';

import '../assets/scss/app.scss';

import AppNavbar from '../components/AppNavbar';

const AppFrontend = ({children}) => {
  return (
    <div id="app">
      <AppNavbar/>
      <Container>
        {children}
      </Container>
    </div>
  );
};

export default AppFrontend;
