import React from 'react';
import {Container} from 'reactstrap';

import '../assets/scss/admin/app.scss';

const AppBackend = ({children}) => {
  return (
    <>
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
