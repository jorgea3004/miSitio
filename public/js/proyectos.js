class Proyectos extends React.Component {
  render() {
    return (
      React.createElement("section", {},
        React.createElement("h3", {},"Mis Proyectos"),
        React.createElement("p", {className:"teamline"},""),
        React.createElement("div", {className:"fourths_portfolio"},
          React.createElement("h4", {}, "Televisa Internacional",
            React.createElement("br", {}),
            React.createElement("span", {},"Ver sitio")
          ),
          React.createElement("a", {href:"http://www.televisainternacional.tv/", target:"_blank"},
            React.createElement("img", {src:"http://yorch3004.xyz/public/img/proyectos/tvsaint.jpg",alt:"Televisa Internacional"})
          )
        ),
        React.createElement("div", {className:"fourths_portfolio"},
          React.createElement("h4", {}, "CEA",
            React.createElement("br", {}),
            React.createElement("span", {},"Ver sitio")
          ),
          React.createElement("a", {href:"http://www.ceatelevisa.com/", target:"_blank"},
            React.createElement("img", {src:"http://yorch3004.xyz/public/img/proyectos/ceaicon.jpg",alt:"CEA"})
          )
        ),
        React.createElement("div", {className:"fourths_portfolio"},
          React.createElement("h4", {}, "Hablando Sola",
            React.createElement("br", {}),
            React.createElement("span", {},"Ver sitio")
          ),
          React.createElement("a", {href:"http://www2.esmas.com/hablando-sola/", target:"_blank"},
            React.createElement("img", {src:"http://yorch3004.xyz/public/img/proyectos/hablandosola.jpg",alt:"Hablando Sola"})
          )
        ),
        React.createElement("div", {className:"fourths_portfolio"},
          React.createElement("h4", {}, "PlayCity",
            React.createElement("br", {}),
            React.createElement("span", {},"Ver sitio")
          ),
          React.createElement("a", {href:"http://www.playcity.com.mx/", target:"_blank"},
            React.createElement("img", {src:"http://yorch3004.xyz/public/img/proyectos/playcityicon.jpg",alt:"PlayCity"})
          )
        ),
        React.createElement("div", {className:"fourths_portfolio"},
          React.createElement("h4", {}, "StandParados",
            React.createElement("br", {}),
            React.createElement("span", {},"Ver sitio")
          ),
          React.createElement("a", {href:"http://www2.esmas.com/standparados/", target:"_blank"},
            React.createElement("img", {src:"http://yorch3004.xyz/public/img/proyectos/standparadosicon.jpg",alt:"StandParados"})
          )
        ),
        React.createElement("hr", {className:'cleanit'}),
        React.createElement("div", {className:'cara'},''),
        React.createElement("p", {className:'textit'},'Sólo son una muestra, en lo que sigo aprendiendo.')

      )
    )
  }
}

ReactDOM.render(<Proyectos />, document.getElementById("content_inner"));