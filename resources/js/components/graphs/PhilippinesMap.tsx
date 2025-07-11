"use client";

import React from "react";
import { MapContainer, TileLayer } from "react-leaflet";
import L from "leaflet";

import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
  CardDescription,
} from "@/components/ui/card";

import iconRetinaUrl from "leaflet/dist/images/marker-icon-2x.png";
import iconUrl from "leaflet/dist/images/marker-icon.png";
import shadowUrl from "leaflet/dist/images/marker-shadow.png";

// Fix default icon issue in React Leaflet + Webpack
delete (L.Icon.Default.prototype as any)._getIconUrl;

L.Icon.Default.mergeOptions({
  iconRetinaUrl,
  iconUrl,
  shadowUrl,
});

// Define bounds roughly covering the Philippines (southwest and northeast corners)
const philippinesBounds: L.LatLngBoundsExpression = [
  [4.5, 116.0],  // southwest lat,lng
  [21.5, 130.0], // northeast lat,lng
];

export function PhilippinesMap() {
  return (
    <Card>
      <CardHeader>
        <CardTitle>Philippines Map</CardTitle>
        <CardDescription>Interactive map bounded to the Philippines</CardDescription>
      </CardHeader>
      <CardContent className="relative overflow-hidden" style={{ height: 600, width: "100%" }}>
        <MapContainer
          center={[12.8797, 121.774]}
          zoom={6}
          style={{ height: "100%", width: "100%" }}
          scrollWheelZoom={true}
          minZoom={5}
          maxZoom={9}
          maxBounds={philippinesBounds}
          maxBoundsViscosity={0.8} // makes boundaries sticky
        >
          <TileLayer
            attribution='&copy; <a href="https://osm.org/copyright">OpenStreetMap</a>'
            url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
          />
        </MapContainer>
      </CardContent>
    </Card>
  );
}
