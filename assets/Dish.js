import React, {Component} from 'react';
import axios from 'axios';
import { PieChart } from 'react-minimal-pie-chart';
import {PaginatedList} from "react-paginated-list";
import {Link} from "react-router-dom";

class Dish extends Component {
    constructor() {
        super();
        this.state = { items: [], loading: true};
    }

    componentDidMount() {
        this.getItems();
    }

    getItems() {
        axios.get(`/api/uses`).then(items => {
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
                            <h2 className="text-center">🥘</h2>
                        </div>

                        <div className="row">
                            <div className="col-sm-6">
                                <div className="card">
                                    <div className="card-body">
                                        <h5 className="card-title">Ranking</h5>
                                        <p className="card-text">#1</p>
                                    </div>
                                </div>
                            </div>
                            <div className="col-sm-6">
                                <div className="card">
                                    <div className="card-body">
                                        <h5 className="card-title">Uses</h5>
                                        <p className="card-text">33</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-sm-9">
                                <div className="card ">
                                    <div className="card-header">
                                        <ul className="nav nav-tabs card-header-tabs pull-right" id="myTab"
                                            role="tablist">
                                            <li className="nav-item">
                                                <a className="nav-link active" id="main-tab" data-toggle="tab"
                                                   href="#mainSimilar" role="tab" aria-controls="mainSimilar"
                                                   aria-selected="true">Overall</a>
                                            </li>
                                            <li className="nav-item">
                                                <a className="nav-link" id="monday-tab" data-toggle="tab"
                                                   href="#mondaySimilar" role="tab" aria-controls="mondaySimilar"
                                                   aria-selected="false">Monday</a>
                                            </li>
                                            <li className="nav-item">
                                                <a className="nav-link" id="tuesday-tab" data-toggle="tab"
                                                   href="#tuesdaySimilar" role="tab" aria-controls="tuesdaySimilar"
                                                   aria-selected="false">Tuesday</a>
                                            </li>
                                            <li className="nav-item">
                                                <a className="nav-link" id="wednesday-tab" data-toggle="tab"
                                                   href="#wednesdaySimilar" role="tab" aria-controls="wednesdaySimilar"
                                                   aria-selected="false">Wednesday</a>
                                            </li>
                                            <li className="nav-item">
                                                <a className="nav-link" id="thursday-tab" data-toggle="tab"
                                                   href="#thursdaySimilar" role="tab" aria-controls="thursdaySimilar"
                                                   aria-selected="false">Thursday</a>
                                            </li>
                                            <li className="nav-item">
                                                <a className="nav-link" id="friday-tab" data-toggle="tab"
                                                   href="#fridaySimilar" role="tab" aria-controls="fridaySimilar"
                                                   aria-selected="false">Friday</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div className="card-body">
                                        <div className="tab-content" id="myTabContent">
                                            <div className="tab-pane show active" id="mainSimilar" role="tabpanel"
                                                 aria-labelledby="main-tab">...
                                            </div>
                                            <div className="tab-pane" id="mondaySimilar" role="tabpanel"
                                                 aria-labelledby="monday-tab">...
                                            </div>
                                            <div className="tab-pane" id="tuesdaySimilar" role="tabpanel"
                                                 aria-labelledby="tuesday-tab">...
                                            </div>
                                            <div className="tab-pane" id="wednesdaySimilar" role="tabpanel"
                                                 aria-labelledby="wednesday-tab">...
                                            </div>
                                            <div className="tab-pane" id="thursdaySimilar" role="tabpanel"
                                                 aria-labelledby="thursday-tab">...
                                            </div>
                                            <div className="tab-pane" id="fridaySimilar" role="tabpanel"
                                                 aria-labelledby="friday-tab">...
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="col-sm-3">
                                <PieChart
                                    data={[
                                        { title: 'One', value: 10, color: '#E38627' },
                                        { title: 'Two', value: 15, color: '#C13C37' },
                                        { title: 'Three', value: 20, color: '#6A2135' },
                                    ]}
                                />
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
                                                                {item.date}
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

export default Dish;