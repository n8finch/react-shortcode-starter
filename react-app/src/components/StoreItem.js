import React from "react";

function StoreItem(props) {
  const store = props.store;
  return (
    <div className="col-md-4 archive-store-item">
      <div className="image-container">
        <a href={store.link}>
          <img src={store.thumb} alt={store.alt} />
        </a>
      </div>
      <div className="store-item-info">
        <h3>{store.title}</h3>
        <p className="store-item-state">{store.cat}</p>
        <div className="location-buttons">
          <a
            className="location-direction order-pickup theme-button large"
            href={store.link}
          >
            See Store &gt;
          </a>
        </div>
      </div>
    </div>
  );
}

export default StoreItem;
