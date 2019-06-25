import React from "react";
// TODO: Get a webpack loader, see errors
// import "./App.css";
import PostItem from "./components/PostItem";

class App extends React.Component {
  constructor(props) {
    super();

    const externalPosts = props;

    this.state = {
      categories: [],
      search: "",
      select: "",
      posts: []
    };
    this.handleInputChange = this.handleInputChange.bind(this);
    this.handleSelectChange = this.handleSelectChange.bind(this);
    this.sortPost = this.sortPost.bind(this);
  }

  componentWillMount() {
    this.setState({
      posts: this.props.posts.postQuery,
      categories: this.props.posts.postCategories
    });
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

  sorePostSearch(post) {}

  sortPost(post) {
    if ("" === this.state.search && "" === this.state.select) {
      return <PostItem key={post.title} post={post} />;
    }

    if (
      "" !== this.state.select &&
      -1 < post.cat.indexOf(this.state.select) &&
      "" === this.state.search
    ) {
      return <PostItem key={post.title} post={post} />;
    }

    if (
      "" !== this.state.search &&
      -1 < post.title.toLowerCase().indexOf(this.state.search.toLowerCase()) &&
      "" === this.state.select
    ) {
      return <PostItem key={post.title} post={post} />;
    }

    if (
      -1 < post.title.toLowerCase().indexOf(this.state.search.toLowerCase()) &&
      -1 < post.cat.indexOf(this.state.select)
    ) {
      return <PostItem key={post.title} post={post} />;
    }

    return;
  }

  render() {
    return (
      <div className="App">
        <form className="arichive-post-search" action="/posts/" method="get">
          <input
            onChange={e => this.handleInputChange(e)}
            value={this.state.search}
            placeholder="Search Posts"
          />
          <label>
            <select
              className="medium gfield_select"
              value={this.state.select}
              onChange={e => this.handleSelectChange(e)}
            >
              <option value="">Select Cetegory</option>
              {this.state.categories.map(cat => {
                return <option value={cat}>{cat}</option>;
              })}
            </select>
          </label>
        </form>

        <div className="archive-post-items post-results">
          {this.state.posts.map(post => {
            const sortedPosts = this.sortPost(post);
            return sortedPosts;
          })}
        </div>
      </div>
    );
  }
}

export default App;
