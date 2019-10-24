import React, {useState} from 'react';
import {
  Collapse,
  Nav,
  Navbar,
  NavbarBrand,
  NavbarToggler,
  NavItem,
  NavLink,
} from 'reactstrap';
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome';
import {faHome} from '@fortawesome/pro-duotone-svg-icons';

const AppNavbar = () => {
  const [collapsed, setCollapsed] = useState(true);

  const toggleNavbar = () => setCollapsed(!collapsed);

  return (
    <div>
      <Navbar color="blue" dark expand="md">
        <NavbarBrand className="text-uppercase" href="/">Ocea CRM</NavbarBrand>
        <NavbarToggler onClick={toggleNavbar}/>
        <Collapse isOpen={!collapsed} navbar>
          <Nav className="ml-auto" navbar>
            <NavItem>
              <NavLink href="/" className="text-uppercase">
                <FontAwesomeIcon icon={['fad', 'home']} size="lg"/> Home
              </NavLink>
            </NavItem>
            <NavItem>
              <NavLink href="/" className="text-uppercase">
                <FontAwesomeIcon icon={['fad', 'comments-alt']} size="lg"/> Blog
              </NavLink>
            </NavItem>
          </Nav>
        </Collapse>
      </Navbar>
    </div>
  );
};

export default AppNavbar;
