class Proyectos extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      nombre: '',
      email: '',
      url: '',
      message: ''
    };

    this.handleInputChange = this.handleInputChange.bind(this);
  }

  handleChange(event) {
    this.setState({nombre: event.target.nombre});
  }

  handleInputChange(event) {
    const target = event.target;
    const value = target.type === 'checkbox' ? target.checked : target.value;
    const name = target.name;

    this.setState({
      [name]: value
    });
  }

  handleSubmit(event) {
    event.preventDefault();
  }

  render() {
    return (
      React.createElement("section", {},
        React.createElement("h3", {},"Escribe un mensaje"),
        React.createElement("p", {className:"textit"},"Escribeme algo si gustas contactárme."),
        React.createElement("form", {action:"http://yorch3004.xyz/contacto/validate",method:"post",className:"formit"},
          React.createElement("input", {type:"text",name:"nombre",id:"nombre",placeholder:"Tu Nombre", value:this.state.nombre, onChange:this.handleInputChange }),
          React.createElement("input", {type:"email",name:"email",id:"email",placeholder:"Tu Email", value:this.state.email, onChange:this.handleInputChange }),
          React.createElement("input", {type:"text",name:"url",id:"url",placeholder:"Tu sitio", value:this.state.url, onChange:this.handleInputChange }),
          React.createElement("textarea", {type:"text",name:"message",id:"message",placeholder:"Tu mensaje", value:this.state.message, onChange:this.handleInputChange }),
          React.createElement("input", {type:"submit",name:'envia',id:"envia",value:"ENVIA",className:'button_submit'})
        ),
        React.createElement("hr", {className:'cleanit'})
      )
    )
  }
}

ReactDOM.render(<Proyectos />, document.getElementById("content_inner"));