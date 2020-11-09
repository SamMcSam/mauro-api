import React, {Component} from 'react';
import axios from 'axios';

class Menu extends Component {
    constructor() {
        super();
        this.state = { items: [], loading: true};
    }

    componentDidMount() {
        this.getItems();
    }

    getItems() {
        axios.get(`/api/menu`).then(items => {
            this.setState({ items: items.data, loading: false})
        })
    }

    render() {
        const loading = this.state.loading;
        return(
            <div>
                <section className="row-section">
                    <div className="container">
                        <div className="row">
                            <h2 className="text-center"><span>Current menu</span></h2>
                        </div>
                        {loading ? (
                            <div className={'row text-center'}>
                                <span className="fa fa-spin fa-spinner fa-4x"></span>
                            </div>
                        ) : (
                            <div className={'row'}>
                                { this.state.items.map(menu =>
                                    <div className="col-md-10 offset-md-1 row-block" key={menu.id}>
                                        <h3>{menu.date}</h3>
                                        <ul>
                                            {menu.items.map((item,i) =>
                                                <li key={i}>{item}</li>
                                            )}
                                        </ul>
                                    </div>
                                )}
                            </div>
                        )}
                    </div>
                </section>
            </div>
        )
    }
}
export default Menu;