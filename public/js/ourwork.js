class Ourwork extends React.Component {
  constructor() {
    super();
    this.state = {
      showModal: 'block'
    }

  }
  
  render() {
    return (
      React.createElement("section", {},
        React.createElement("h3", {},""),
        React.createElement("p", {className:"teamline"},""),
        React.createElement("section", {id:'galeriaFt'},''),
        React.createElement("section", {id:'galeriaBd'},''),
        React.createElement("hr", {className:'cleanit'}),
        React.createElement("div", {id:'pagination'},''),
        React.createElement("div", {className:'cara'},''),
        React.createElement("p", {className:'textit'},'')

      )
    )
  }
}
ReactDOM.render(<Ourwork />, document.getElementById("content_inner"));
