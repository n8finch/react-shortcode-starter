import React from "react";
import "./App.css";
import StoreItem from "./components/StoreItem";

class App extends React.Component {
  constructor(props) {
    super();

    const externalStores = props;

    this.state = {
      categories: [],
      search: "",
      select: "",
      stores: []
    };
    this.handleInputChange = this.handleInputChange.bind(this);
    this.handleSelectChange = this.handleSelectChange.bind(this);
    this.sortStore = this.sortStore.bind(this);
  }

  componentWillMount() {
    this.setState({
      stores: this.props.stores.storeQuery,
      categories: this.props.stores.storeCategories
    });
    console.log(this.props);
  }

  handleInputChange(e) {
    this.setState({
      search: e.target.value
    });
  }

  handleSelectChange(e) {
    this.setState({
      select: e.target.value
    });
  }

  soreStoreSearch(store) {}

  sortStore(store) {
    if ("" === this.state.search && "" === this.state.select) {
      return <StoreItem key={store.title} store={store} />;
    }

    if (
      "" !== this.state.select &&
      -1 < store.cat.indexOf(this.state.select) &&
      "" === this.state.search
    ) {
      return <StoreItem key={store.title} store={store} />;
    }

    if (
      "" !== this.state.search &&
      -1 < store.title.toLowerCase().indexOf(this.state.search.toLowerCase()) &&
      "" === this.state.select
    ) {
      return <StoreItem key={store.title} store={store} />;
    }

    if (
      -1 < store.title.toLowerCase().indexOf(this.state.search.toLowerCase()) &&
      -1 < store.cat.indexOf(this.state.select)
    ) {
      return <StoreItem key={store.title} store={store} />;
    }

    return;
  }

  render() {
    return (
      <div className="App">
        <form className="arichive-store-search" action="/stores/" method="get">
          <input
            onChange={e => this.handleInputChange(e)}
            value={this.state.search}
            placeholder="Search Stores"
            style={{
              backgroundColor: "#f7f7f7",
              border: "1px solid #eee",
              color: "#777",
              marginRight: "20px",
              paddingLeft: "5px"
            }}
          />
          <label>
            <select
              className="medium gfield_select"
              value={this.state.select}
              onChange={e => this.handleSelectChange(e)}
              style={{
                backgroundImage:
                  'url("/wp-content/plugins/milios-recipes-plugin/images/arrow-down.png")'
              }}
            >
              <option value="">Select Location</option>
              {this.state.categories.map(cat => {
                return <option value={cat}>{cat}</option>;
              })}
            </select>
          </label>
          {/* <input type="submit" value="Search" /> */}
          <div>
            <a
              class="location-direction order-pickup theme-button large"
              href="/locations"
            >
              <i class="ticon ticon-location-arrow" /> Find Your Store
            </a>
          </div>
        </form>

        <div className="archive-store-items store-results">
          {this.state.stores.map(store => {
            const sortedStores = this.sortStore(store);
            return sortedStores;
          })}
        </div>
      </div>
    );
  }
}

export default App;
