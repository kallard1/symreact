import React from 'react';
import {Container, Nav} from 'reactstrap';
import {Link} from 'react-router-dom';

const AppNavbar = () => {
  return (
    <Nav vertical>
      <Container fluid>
        <Link className="navbar-brand" to="#">...</Link>
      </Container>
    </Nav>
  );
};

export default AppNavbar;
