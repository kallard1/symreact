import React from 'react';
import {Container} from 'reactstrap';

import '../assets/scss/admin/app.scss';
import AppNavbar from '../components/admin/AppNavbar';

const AppBackend = ({children}) => {
  return (
    <>
      <AppNavbar />
      <div className="main-content">
        <div className="header">
          <div className="header-body">
            <div className="row align-items-end">
              <div className="col">
                <h1 className="header-title">Bla bla bla</h1>
              </div>
            </div>
          </div>
        </div>
        <Container fluid>
          {children}
        </Container>
      </div>
    </>
  );
};

export default AppBackend;
