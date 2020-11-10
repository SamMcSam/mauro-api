import React, {Component} from 'react';
import axios from 'axios';
import Dish from './Dish';
import {Link, Redirect, Route, Switch} from "react-router-dom";
import Menu from "./Menu";
import Predictions from "./Predictions";
import {PaginatedList} from 'react-paginated-list';

class Stats extends Component {
    constructor() {
        super();
        this.state = { items: [], loading: true};
    }

    componentDidMount() {
        this.getItems();
    }

    getItems() {
        axios.get(`/api/stats`).then(items => {
            this.setState({ items: items.data, loading: false})
        })
    }

    render() {
        const loading = this.state.loading;
        return (
            <div>
                <section className="row-section">
                    <div className="container">
                        <div className="row">
                            <h2 className="text-center">📈</h2>
                        </div>

                        <div className="row">
                            <div className="col-sm-6">
                                <div className="card">
                                    <div className="card-body">
                                        <h5 className="card-title">Total dishes</h5>
                                        <p className="card-text">1200</p>
                                    </div>
                                </div>
                            </div>
                            <div className="col-sm-6">
                                <div className="card">
                                    <div className="card-body">
                                        <h5 className="card-title">Total menus</h5>
                                        <p className="card-text">52</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {loading ? (
                            <div className={'row text-center'}>
                                <span className="fa fa-spin fa-spinner fa-4x"></span>
                            </div>
                        ) : (
                            <div className={'row'}>
                                <div className="col-sm-12">
                                    <ul className="list-group">
                                        <PaginatedList
                                            list={this.state.items}
                                            itemsPerPage={10}
                                            renderList={(list) => (
                                                <>
                                                    {list.map((item, id) => {
                                                        return (
                                                            <li className="list-group-item"key={id}>
                                                                <Link to={"/dish"}>#{id+1} {item.uses} {item.name}</Link>
                                                            </li>
                                                        );
                                                    })}
                                                </>
                                            )}
                                        />
                                    </ul>
                                </div>
                            </div>
                        )}

                    </div>
                </section>
            </div>
        )
    }
}

export default Stats;