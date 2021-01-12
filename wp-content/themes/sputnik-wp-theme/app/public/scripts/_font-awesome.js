//* You cant comment some icons for smaller js file size
//! If you know icons from project please use only this icons! Choose them from array by filter or map allIcons.

import { library, dom } from "@fortawesome/fontawesome-svg-core";

import * as Icons from "@fortawesome/free-solid-svg-icons";

import * as Regular from "@fortawesome/free-regular-svg-icons";

import * as Brands from "@fortawesome/free-brands-svg-icons";

const iconList = Object.keys(Icons)
  .filter((key) => key !== "fas" && key !== "prefix")
  .map((icon) => Icons[icon]);

const regularList = Object.keys(Regular)
.filter((key) => key !== "far" && key !== "prefix")
.map((icon) => Regular[icon]);

const brandsList = Object.keys(Brands)
  .filter((key) => key !== "fab" && key !== "prefix")
  .map((icon) => Brands[icon]);

const allIcons = [...iconList, ...brandsList, ...regularList];

// add icons
library.add(allIcons);

dom.watch();