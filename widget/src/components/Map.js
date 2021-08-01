import { MapContainer, Marker, Popup, TileLayer } from 'react-leaflet'
import L from 'leaflet';
import MapPopup from './MapPopup.js'

import 'leaflet/dist/leaflet.css'

/*
delete L.Icon.Default.prototype._getIconUrl;

L.Icon.Default.mergeOptions({
  iconRetinaUrl: '/images/marker-icon-2x.png',
  iconUrl: '/images/marker-icon.png',
  shadowUrl: '/images/marker-shadow.png'
});

*/


const Map = ({nodes}) => {
  return (
    <MapContainer center={[51.505, -0.09]} zoom={2} scrollWheelZoom={false} style={{height: "70vh", width: "85%", margin: "auto"}}>
      <TileLayer
        attribution='&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
      />
      {nodes.map((node) => {
        if (node.data) {
          const id = node.id;
          node = node.data;
          node.id = id;
        }
        return(
          <div key={`${node.id || node.objectID}`}>
            {node.geolocation ?
            (<Marker position={[parseFloat(node.geolocation.lat), parseFloat(node.geolocation.lon)]}>
            <Popup>
              <MapPopup node={node} />
            </Popup>
          </Marker>):
          null}

          </div>
          )
      })}
    </MapContainer>
  )
}

export default Map
