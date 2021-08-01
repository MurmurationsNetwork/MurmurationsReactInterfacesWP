import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import reportWebVitals from './reportWebVitals';
import MurmurationsInterface from './components/MurmurationsInterface.js';

const reactDirectory = document.getElementById('murmurations-react-directory');

const reactMap = document.getElementById('murmurations-react-map');

if (reactDirectory) {
  const settings = window.reactWidgetSettings;
  ReactDOM.render(<MurmurationsInterface settings={settings} interface="directory"/>, reactDirectory);
}

if (reactMap) {
  const settings = window.reactWidgetSettings;
  ReactDOM.render(<MurmurationsInterface settings={settings} interface="map" />, reactMap);
}

/*
ReactDOM.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,
  document.getElementById('root')
);
*/

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
