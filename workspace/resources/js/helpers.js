export const trans = (key, replace = {}) => {
  let translation = window.__langData[key] || "";
  for (let placeholder in replace) {
    translation = translation.replace(`:${placeholder}`, replace[placeholder]);
  }
  return translation;
};
