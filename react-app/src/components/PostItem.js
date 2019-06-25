import React from "react";

function PostItem(props) {
  const post = props.post;
  return (
    <div className="col-md-4 archive-post-item">
      <div className="image-container">
        <a href={post.link}>
          <img src={post.thumb} alt={post.alt} />
        </a>
      </div>
      <div className="post-item-info">
        <h3>{post.title}</h3>
        <p className="post-item-state">{post.cat}</p>
        <div className="location-buttons">
          <a
            className="location-direction order-pickup theme-button large"
            href={post.link}
          >
            See Post &gt;
          </a>
        </div>
      </div>
    </div>
  );
}

export default PostItem;
