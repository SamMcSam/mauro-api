import React, {Component} from 'react';
import {Route, Switch,Redirect, Link, withRouter} from 'react-router-dom';
import Menu from './Menu';

class Home extends Component {

    render() {
        return (
            <div>
                <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                    <Link className={"navbar-brand"} to={"/"}> Mauro API dashboard </Link>
                    <div className="collapse navbar-collapse" id="navbarText">
                        <ul className="navbar-nav mr-auto">
                            <li className="nav-item">
                                <Link className={"nav-link"} to={"/menu"}> Menu </Link>
                            </li>
                            <li className="nav-item">
                                <Link className={"nav-link"} to={"/stats"}> Stats </Link>
                            </li>
                            <li className="nav-item">
                                <Link className={"nav-link"} to={"/predictions"}> Predictions </Link>
                            </li>
                        </ul>
                    </div>
                </nav>
                <Switch>
                    <Redirect exact from="/" to="/menu" />
                    <Route path="/menu" component={Menu} />
                </Switch>
            </div>
        )
    }
}

export default Home;