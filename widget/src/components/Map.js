import { MapContainer, Marker, Popup, TileLayer } from 'react-leaflet'
import L from 'leaflet';
import MapPopup from './MapPopup.js'

import 'leaflet/dist/leaflet.css'

delete L.Icon.Default.prototype._getIconUrl;

const Map = ({nodes, settings}) => {

  L.Icon.Default.mergeOptions({
    iconRetinaUrl: settings.clientPathToApp+'public/images/marker-icon-2x.png',
    iconUrl: settings.clientPathToApp+'public/images/marker-icon.png',
    shadowUrl: settings.clientPathToApp+'public/images/marker-shadow.png'
  });

  return (
    <MapContainer center={settings.mapCenter} zoom={settings.mapZoom} scrollWheelZoom={settings.mapAllowScrollZoom} style={{height: "70vh", width: "100%", margin: "auto"}}>
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
