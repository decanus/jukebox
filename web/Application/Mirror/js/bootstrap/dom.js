/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

window.dom = (tagName, attributes, ...nodes) => {
  const element = document.createElement(tagName)

  if (attributes != null) {
    Object.keys(attributes).forEach((name) => {
      element.setAttribute(name, attributes[ name ])
    })
  }

  nodes.forEach((node) => {
    if (node instanceof Node) {
      element.appendChild(node)
    } else {
      element.appendChild(document.createTextNode(node))
    }
  })

  return element
}
