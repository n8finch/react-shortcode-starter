import React from "react";

function PostItem(props) {
  const post = props.post;
  return (
    <div className="post-item">
      <div className="image-container">
        <a href={post.link}>
          <img src={post.thumb} alt={post.alt} />
        </a>
      </div>
      <div className="post-item-info">
        <h3>{post.title}</h3>
        <p className="post-item-category">{post.cat}</p>
        <div className="post-buttons">
          <a className="post-button" href={post.link}>
            Read more...
          </a>
        </div>
      </div>
    </div>
  );
}

export default PostItem;
