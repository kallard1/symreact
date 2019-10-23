import React from 'react';
import {Container} from 'reactstrap';

import '../assets/admin/app.scss';

const AppBackend = ({children}) => {
  return (
    <div className="main-content">
      <Container fluid>
        {children}
      </Container>
    </div>
  );
};

export default AppBackend;
