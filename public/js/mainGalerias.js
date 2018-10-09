class GaleriasItem extends React.Component {
  propTypes: {
    id: React.PropTypes.string.isRequired,
    gal: React.PropTypes.string.isRequired,
    foto: React.PropTypes.string.isRequired
  }

  render() {
    return (
        React.createElement("div", {className:"fourths_portfolio"},
          React.createElement("h4", {},this.props.title,
            React.createElement("br", {}),
            React.createElement("span", {},"Ver más")
          ),
          React.createElement("a", {href:"http://yorch3004.xyz/galeria/"+this.props.gal+ '/'},
            React.createElement("img", {src:"http://yorch3004.xyz/public/uploads/galerias/"+this.props.gal+ '/'+this.props.foto,alt:"item"+this.props.id})
          )
        )
    )
  }
}

var galeriasItemElements = galerias
  .filter(function(contact) { return contact.foto })
  .map(function(contact) { return React.createElement(GaleriasItem, contact) })

var rootElement =
  React.createElement("div", {id:"content"}, 
    React.createElement("h3", {}, "Galerías"),
    galeriasItemElements,
    React.createElement("div", {className:"cara"},""),
    React.createElement("div", {className:"about_blok"},
      React.createElement("h3", {},"Acerca de Mí"),
      React.createElement("p", {className:"about"},""),
      React.createElement("a", { className:"button_light",href:"http://yorch3004.xyz/bio"},"Sigue leyendo")
    ),
    React.createElement("div", {className:"testimonials"},
      React.createElement("div", {className:"quote"},
        React.createElement("a", {className:"twitter-timeline",href:"https://twitter.com/jorgea3004",height:"190",'data-tweet-limit':"1",'data-widget-id':"271729451757346816",'data-chrome':"nofooter noborders transparent"},"Sigue leyendo")
      ),
      React.createElement("span", {className:"testimonials_bottom"},""),
      React.createElement("span", {className:"by"},"@jorgea3004")
    )
  )

ReactDOM.render(rootElement, document.getElementById("contentm"))
