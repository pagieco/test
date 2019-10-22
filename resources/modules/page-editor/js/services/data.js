export function fetchHeadData(id) {
  const element = document.getElementById(id);

  return element
    ? JSON.parse(element.innerHTML)
    : null;
}

export const objectClean = obj => JSON.parse(JSON.stringify(obj));
