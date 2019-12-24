const MediaQueries = {
  desktop: {
    query: 'screen',
    canvasSize: '100%',
  },
  tablet: {
    query: 'screen and (max-width: 1024px)',
    canvasSize: '1024px',
  },
  mobile_landscape: {
    query: 'screen and (max-width: 600px)',
    canvasSize: '600px',
  },
  mobile_portrait: {
    query: 'screen and (max-width: 600px)',
    canvasSize: '600px',
  },
};

export function getMediaQuery(device) {
  return MediaQueries[device].query;
}

export function getCanvasSize(device) {
  return MediaQueries[device].canvasSize;
}
