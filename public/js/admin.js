
class Login extends React.Component {
  constructor() {
    super();
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleSubmit(event) {
    event.preventDefault();
    const data = new FormData(event.target);
    
    fetch('http://localhost/misitio/admin/valida/', {
      method: 'POST',
      body: data,
    }).then(results => {
      return results.json();
    }).then(data => {
      if (data.estatus==1) {
        ReactDOM.render(<ListView page={1} />, document.getElementById("app"))
      } else {
        alert(data.msg)
      }
    });
  }

  render() {
    return (
      <section id="login">
      <form onSubmit={this.handleSubmit}>
        <img src="http://localhost/misitio/public/img/default-user-image.png"/>
        <input id="usuario" name="user" type="text" placeholder='Usuario...'/>
        <input id="contrasena" name="pass" type="password" placeholder='Password...' />
        <div className="g-recaptcha" data-sitekey="6LeRtjgUAAAAAIZnQrtuSLGySfRlavoTomSH1WYp"></div>
        <button>Accesar</button>
      </form>
      </section>
    );
  }
}

class FormNew extends React.Component {
  getInitialState() {
      return {
          key: 0,
          sexiones: [],
          idm:'', 
          image:'', 
          titulo:'', 
          clase:'', 
          seccion:'', 
          open:'', 
          linku:''
      }
  }

  constructor(props) {
    super(props);
    this.state = {         
          key: 0,
          sexiones: [],
          idm:'', 
          image:'', 
          titulo:'', 
          clase:'', 
          seccion:'', 
          open:'', 
          linku:''
};
    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleChange = this.handleChange.bind(this);
    this.closeForm = this.closeForm.bind(this);
    editing:false;
  }

  propTypes: {
    contact: React.PropTypes.object.isRequired
  }

  componentWillMount(){
    var self=this;
    var sexiones = [];
    var idmc = this.props.contact.ide;
    var imagec = this.props.contact.icono;
    var tituloc = this.props.contact.desc;
    var clasec = this.props.contact.clase;
    var linkuc = this.props.contact.linku;
    var seccc = this.props.contact.secc;
    var openc = this.props.contact.open;
    this.setState({ sexiones:sexiones, idm:idmc, image:imagec, titulo:tituloc, clase:clasec, seccion:seccc, open:openc, linku:linkuc });

    console.log("item1: " + this.props.contact.desc);
    document.getElementById('formulario').style.display='block';
    fetch('http://localhost/misitio/Desktopadm/secciones/', {
      method: 'GET'
    }).then(function(response) {
      if (response.status >= 400) {
        throw new Error("Bad response from server");
      }
      return response.json();
    }).then(function(data) {
      if (data.post.length>0) {
        var sexions = [];
          data.post.map(function(datac,index) {
            sexions.push({key:index, idSeccion: datac.idSeccion, descripcion: datac.descrip});
          })
          self.setState({sexiones:sexions})
        }
    });
  }

  handleChange(event){
    const target = event.target;
    const value = target.type === 'checkbox' ? target.checked : target.value;
    const name = target.name;
    //console.log(name +":"+ value);

    this.setState({
      [ name ]: value
    });
  }

  handleSubmit(event) {
    event.preventDefault();
    const data = new FormData(event.target);
    var self = this;
    fetch('http://localhost/misitio/Desktopadm/elementNew/', {
      method: 'POST',
      body: data
    }).then(results => {
      return results.json();
    }).then(data => {
      if (data.estatus==1) {
        document.getElementById('formulario').style.display='none';
        ReactDOM.render(<Extra />, document.getElementById("formulario"));
        ReactDOM.render(<ListView key={Math.random()} />, document.getElementById("app"));
      } else {
        alert(data.msg)
      }
    })
  }

  closeForm(event) {
    event.preventDefault();
    ReactDOM.render(<Extra />, document.getElementById("formulario"));
    document.getElementById('formulario').style.display='none';
  }

  render() {
    let self=this;
    var selopen1 = '';
    var selopen2 = '';
    if (self.state.open!='' && self.state.open=='2') {selopen1='selected';}else{selopen1='';}
    if (self.state.open!='' && self.state.open=='1') {selopen2='selected';}else{selopen2='';}
    return (
        React.createElement('form', {
              className: 'ContactForm',
              id: 'ContactForm',
              name: 'ContactForm',
              ref:'ContactForm',
              encType:"multipart/form-data",
              onSubmit:this.handleSubmit
            },
            React.createElement('input', {
              type: 'hidden',
              value: this.state.idm,
              id: 'idm',
              name: 'idm',
              ref:'idm'
            }),
            React.createElement('input', {
              type: 'file',
              placeholder: 'Icono',
              value: this.state.imagen,
              id: 'icono',
              name: 'icono',
              ref:'icono', 
              onChange:this.handleChange
            }),
            React.createElement('input', {
              type: 'text',
              placeholder: 'Titulo',
              value: this.state.titulo,
              id: 'titulo',
              name: 'titulo',
              ref:'titulo', 
              onChange:this.handleChange
            }),
            React.createElement('input', {
              type: 'text',
              placeholder: 'Clase',
              value: this.state.clase,
              id: 'clase',
              name: 'clase',
              ref:'clase', 
              onChange:this.handleChange
            }),
            React.createElement('input', {
              type: 'text',
              placeholder: 'Url',
              value: this.state.linku,
              id: 'linku',
              name: 'linku',
              ref:'linku', 
              onChange:this.handleChange
            }),
            React.createElement('select', {
              id: 'seccion',
              name: 'seccion',
              ref:'seccion', 
              onChange:this.handleChange
              },
              self.state.sexiones.map(function(sexion,index) {
                var selsexion = '';
                if (self.state.seccion!='' && self.state.seccion==sexion.idSeccion) {selsexion='selected';}else{selsexion='';}
                return (
                  React.createElement('option', {
                      value: sexion.idSeccion,
                      key: sexion.idSeccion,
                      ref: sexion.idSeccion,
                      selected:selsexion
                    }, sexion.descripcion)
                  )
              })
            ),
            React.createElement('select', {
              id: 'open',
              name: 'open',
              ref:'open', 
              onChange:this.handleChange
              },
              React.createElement('option', {
                value: '2',
                selected:selopen1
              }, 'Misma'),
              React.createElement('option', {
                value: '1',
                selected:selopen2
              }, 'Nueva')
            ),
            React.createElement('button', {type: 'submit'}, "GUARDAR"),
            React.createElement('button', {type: 'button', onClick:this.closeForm}, "CERRAR")
          )
        )
  }
}

class ListView extends React.Component {
  getInitialState() {
      return {
          key: 0,
          contacts: [],
          page: 1
      }
  }

  constructor(props) {
    super(props);
    var contacts = [];
    this.state = {key:0,contacts,page:1};
    this.handleChange = this.handleChange.bind(this);
    this.handleDelete = this.handleDelete.bind(this);
    this.handleEdition = this.handleEdition.bind(this);
    this.prevPage = this.prevPage.bind(this);
    this.nextPage = this.nextPage.bind(this);
    this.openForm = this.openForm.bind(this);
    this.logout = this.logout.bind(this);
  }

  componentWillMount(){
    this.getItems();
    this.setState({key:Math.random(),page:2});
  }
  
  cleanData(string){
    if (string != undefined || string.length>0) {
      var cad = string;
      string = cad.replace('"','');
      string = string.replace('"','');
    }
    return string;
  }

  getItems(){
    var self=this;
    var pages = this.state.page;
    fetch('http://localhost/misitio/admin/getMenuJson/'+pages)
    .then(function(response) {
      if (response.status >= 400) {
        throw new Error("Bad response from server");
      }
      return response.json();
    })
    .then(function(data) {
      if (data.post.length>0) {
        var contactos=[];
          data.post.map(function(datac,index) {
              contactos.push({
                key:index, 
                ide:datac.ItemID, 
                icono: datac.ItemImage, 
                clase: datac.ItemClass, 
                open: datac.ItemTarget, 
                linku: datac.ItemLink,
                desc:datac.ItemDescription,
                secc:datac.categoria
              });
          });
          self.setState({contacts:contactos})
      }
    });

  }

  handleChange(event) {
    const target = event.target;
    const value = target.type === 'checkbox' ? target.checked : target.value;
    const name = target.name;

    this.setState({
      [name]: value
    });
  }

  handleDelete(event){
    const target = event.target;
    const indice = target.parentElement.parentElement.parentElement.id;
    const namef = target.id;
    if (namef.length>0) {
      var url = 'http://localhost/misitio/desktopadm/deleteElement/'+namef;
      fetch(url).then(function(response) {
        if (response.status >= 400) {
          throw new Error("Bad response from server");
        }
        return response.json();
      }).then(data => {
          if (data.estatus==1) {
            var LosElementosLista = this.state.contacts;
            LosElementosLista.splice(indice,1);
            this.setState({contacts: LosElementosLista});
          } else {
            alert(data.msg);
          }
      })
    }
  }


  handleEdition(event){
    const target = event.target;
    const indice = target.parentElement.parentElement.parentElement.id;
    const namef = target.id;
    var LosElementosLista = this.state.contacts;
    var item = LosElementosLista[indice];
    ReactDOM.render(<FormNew contact={item} />, document.getElementById("formulario"));

  }

  openForm(event) {
    event.preventDefault();
    let dt = [];
    ReactDOM.render(<FormNew contact={dt} />, document.getElementById("formulario"));
    //ReactDOM.render(<FormNew image={dt} idm={dt} clase={dt} target={dt} enlace={dt} titulo={dt} seccion={dt} />, document.getElementById("formulario"));
    document.getElementById('formulario').style.display='block';
  }

  logout(event) {
    const target = event.target;
    ReactDOM.render(<Login />, document.getElementById("app"));
  }

  prevPage(event) {
    var st = this.state.page-1;
    this.setState({page:st });
    console.log(st);
    this.getItems();
    event.preventDefault();
  }

  nextPage(event) {
    var st = this.state.page+1;
    this.setState({page:st })
    console.log(st);
    this.getItems();
    event.preventDefault();
  }

  render() {
    self=this;
    return (
      React.createElement('section',{id:'mainsec'}, 
        React.createElement('div', {className: 'ContactView'},
          React.createElement('h1', {className: 'ContactView-title'}, "Listado"),
          React.createElement('div', {id: 'formView'},
            React.createElement('button', {type: 'button', onClick:this.openForm}, "NUEVO"),
            React.createElement('button', {type: 'button', className:'butonright', onClick:this.logout}, "LOGOUT")
          ),
          React.createElement('div', {id: 'formulario'},''),
          React.createElement('ul', {className: 'ContactView-list'}, 
            this.state.contacts.map(function(contact,index) {
              return (
                React.createElement('li', {className: 'ContactItem',key:index,id:index,ref:index},
                  React.createElement('img', {className: 'ContactItem-image',src:'http://localhost/misitio/public/img/iconos_metro/'+contact.icono}),
                  React.createElement('div', {className: 'ContactItem-description'},
                    React.createElement('h2', {className: 'ContactItem-name'}, contact.desc),
                    React.createElement('label', {className: 'ContactItem-clase'}, contact.clase),
                    React.createElement('label', {className: 'ContactItem-clase'}, contact.link),
                    React.createElement('div', {className: 'ContactItem-clase'}, 
                      React.createElement('img', {className: 'ContactItem-edit', src:'http://localhost/misitio/public/img/notes.png',id:contact.ide,onClick:self.handleEdition}),
                      React.createElement('img', {className: 'ContactItem-delete', src:'http://localhost/misitio/public/img/trash.png',id:contact.ide,onClick:self.handleDelete })
                    )
                  )
                )
              )
            })
          )
      ),
      React.createElement('div', {className: 'ContactPagin'},
        React.createElement('div', {className: 'ContactPaginPrev', onClick: self.prevPage}, '<< Anterior' ),
        React.createElement('div', {className: 'ContactPaginNext', onClick: self.nextPage}, 'Siguiente >>' )
      )
    )//section
    )//return
  } //render
} // class

class Extra extends React.Component {
  render() {
    return (
        <section>
        </section>
      )
  }
} // class
ReactDOM.render(<Login />, document.getElementById("app"));