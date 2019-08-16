class Menu extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
        optionActive: 'home',
        urls: ['home','bio','galerias','proyectos','contacto'],
        carruseles: [],
        galerias: []
    }
    //this.functionActive = this.functionActive.bind(this);
  }
  openMenu(){
    var nav = document.getElementById('menu').style.display;
    if(nav == 'block'){
      document.getElementById('menu').style.display = 'none';
    } else {
      document.getElementById('menu').style.display = 'block';
    }
  }
  renderHome(){
    ReactDOM.render(<Home/>, document.getElementById("wapper"));
  }
  renderBio(event){
    ReactDOM.render(<Biog/>, document.getElementById("wapper"));
  }
  renderGalerias(){
    ReactDOM.render(<Galeria />, document.getElementById("wapper"));
  }
  renderProyectos(){
    ReactDOM.render(<Proyectos />, document.getElementById("wapper"));
  }
  renderContacto(){
    ReactDOM.render(<Contacto />, document.getElementById("wapper"));
  }
  componentDidMount(){
    this.renderHome()
  }
  render() {
    var a = 0;
    let self = this;
    return React.createElement('div',{id:'header_in',name:'header_in'},
      React.createElement('h2',{},
        React.createElement('a',{href:'//yorch3004.xyz/'},
          React.createElement('b',{},'i'),
            'YORCH'
          )
        ),
        React.createElement('div',{className:'menumob', onClick:this.openMenu},''),
        React.createElement('nav',{id:'menu'},
          React.createElement('ul',
            null,
            self.state.urls.map(function(v,i){
              var param = '',clasea='';
              if (self.state.urls[i]=='home') {param=self.renderHome};
              if (self.state.urls[i]=='bio') {param=self.renderBio};
              if (self.state.urls[i]=='galerias') {param=self.renderGalerias};
              if (self.state.urls[i]=='proyectos') {param=self.renderProyectos};
              if (self.state.urls[i]=='contacto') {param=self.renderContacto};
              if (self.state.optionActive==self.state.urls[i]) {clasea='active';}else{clasea=''}
              return React.createElement('li', {key: i},
                React.createElement(
                  'a',
                  {href: '#', onClick:param,id:self.state.urls[i]}, v )
              )
            })
          )
        )
      )
  }
}

class Home extends React.Component {
  state = {
    carruseles: [],
    galerias: []
  }
  constructor(){
    super();
    this.goToGal = this.goToGal.bind(this);
    this.openBio = this.openBio.bind(this);
  }
  openBio(){
    ReactDOM.render(<Biog/>, document.getElementById("wapper"));
  }
  goToGal(event) {
    const target = event.target;
    const value = target.id;
    const name = target.name;
    ReactDOM.render(<GaleryItem gal={value} />, document.getElementById("wapper"));
  }
  componentDidMount() {
    let self = this;
      axios.get("./public/json/galerias.json").then(response => response.data)
        .then(function(data) {
          self.setState({galerias: data.items});
        })
        .catch(function(error) {
          console.log(error);
        });
      axios.get("./public/json/carrusel.json").then(response => response.data)
        .then(function(data) {
          self.setState({carruseles: data.items});
          let j = 0;
          data.items.map(function(i,val){++j;})
          let i = 1;
          let k = 0;
          let l = 0;
          if(j>0){
            let mytimer = setInterval(() => {
              let element=document.getElementById('data'+j);
              if(typeof(element) != 'undefined' && element != null){
              }else{
                clearInterval(mytimer);
              }
              k=i+1;
              if (i>1) { 
                let y = document.getElementById('data'+i);
                y.style.display = 'none';
              };
              let x = document.getElementById('data'+k);
              x.style.display = 'block';
              ++i;
              if (i>=j) {
                let y = document.getElementById('data'+j);
                y.style.display = 'none';
                i=0;
              };
            }, 5000)
          }
        })
        .catch(function(error) {
          console.log(error);
        });
  }
  render(){
    let self = this;
    return React.createElement('div', {id:'main_part'},
      React.createElement('div', {id:'main_part_in'},
        React.createElement('div', {id:'content'}, 
          React.createElement('div', {id:'mainpart'}, 
            React.createElement('div', {className:"navega",id:'anterior'},
              React.createElement('p', {}, '<<')
            ),
            React.createElement('div', {id:"main_part_in_bg",className:"carrousel"}, 
              React.createElement('ul', { className:"bxslider"}, 
                this.state.carruseles.map(function(v,i){
                  return (
                      React.createElement('li', {'data-id':v.id,id:'data'+v.id,key:i},
                        React.createElement('img', {id:i,src:'//yorch3004.xyz/public/uploads/galerias/'+v.gal+ '/'+v.foto})
                      )
                  )
                })
              )
            ),
            React.createElement('div', {className:"navega",id:'siguiente'},
              React.createElement('p', {}, '>>')
            )
          )
        ),
        React.createElement('div', {id:'content2'},
          React.createElement("div", {id:"main2"}, 
            React.createElement("h3", {}, "Galerías"),
              this.state.galerias.map(function(v,i){
                return (
                  React.createElement("div", {className:"fourths_portfolio",key:i},
                    React.createElement("h4", {},v.title,
                      React.createElement("br", {}),
                      React.createElement("span", {},"Ver más")
                    ),
                    React.createElement("a", {href:"#"},
                      React.createElement("img", {src:"//yorch3004.xyz/public/uploads/galerias/"+v.gal+ '/'+v.foto,alt:v.title, id:v.gal, name:v.title, onClick:self.goToGal})
                    )
                  )
                )
              }),
            React.createElement("div", {className:"cara"},""),
            React.createElement("div", {className:"about_blok"},
              React.createElement("h3", {},"Acerca de Mí"),
              React.createElement("p", {className:"about"},""),
              React.createElement("a", { className:"button_light",href:"#", onClick:self.openBio},"Sigue leyendo")
            ),
            React.createElement("div", {className:"testimonials"},
              React.createElement("div", {className:"quote"},
                React.createElement("a", {className:"twitter-timeline",href:"https://twitter.com/jorgea3004",height:"190",'data-tweet-limit':"1",'data-widget-id':"271729451757346816",'data-chrome':"nofooter noborders transparent"},"Sigue leyendo")
              ),
              React.createElement("span", {className:"testimonials_bottom"},""),
              React.createElement("span", {className:"by"},"@jorgea3004")
            )
          )
        )
      )
    )
  }
}

class Biog extends React.Component {
  render() {
    return (
        React.createElement('div',{id:'main'},
          React.createElement('div',{id:'main_part_sect'},
            React.createElement('div',{id:'main_part_in'},
              React.createElement('div',{id:'main_part_inner'},
                React.createElement('h1',{},'Mis Redes')
              )
            )
          ),
          React.createElement('div',{id:'content_inner'},
            React.createElement("section", {},
              React.createElement("h3", {},"Puedes seguirme o contáctarme en:"),
              React.createElement("p", {className:"teamline"},""),
              React.createElement("div", {className:"sixths_team"},
                React.createElement("h4", {}, "GMail",
                  React.createElement("br", {}),
                  React.createElement("span", {},"gmail.com")
                ),
                React.createElement("a", {href:"mailto:jorgea3004@gmail.com", target:"_blank"},
                  React.createElement("img", {src:"//yorch3004.xyz/public/img/social_gmail_logo.png",alt:"GMail"})
                ),
                React.createElement("a", {href:"mailto:jorgea3004@gmail.com",className:"profession", target:"_blank"},"")
              ),
              React.createElement("div", {className:"sixths_team"},
                React.createElement("h4", {}, "Hotmail",
                  React.createElement("br", {}),
                  React.createElement("span", {},"hotmail.com")
                ),
                React.createElement("a", {href:"mailto:jorge3004@hotmail.com", target:"_blank"},
                  React.createElement("img", {src:"//yorch3004.xyz/public/img/social_Live_Hotmail.png",alt:"Hotmail"})
                ),
                React.createElement("a", {href:"mailto:jorge3004@hotmail.com",className:"profession", target:"_blank"},"")
              ),
              React.createElement("div", {className:"sixths_team"},
                React.createElement("h4", {}, "Twitter",
                  React.createElement("br", {}),
                  React.createElement("span", {},"@jorgea3004")
                ),
                React.createElement("a", {href:"http://www.twitter.com/jorgea3004", target:"_blank"},
                  React.createElement("img", {src:"//yorch3004.xyz/public/img/social_twitter-icon-12.png",alt:"Twitter"})
                ),
                React.createElement("a", {href:"http://www.twitter.com/jorgea3004",className:"profession", target:"_blank"},"")
              ),
              React.createElement("div", {className:"sixths_team"},
                React.createElement("h4", {}, "Facebook",
                  React.createElement("br", {}),
                  React.createElement("span", {},"@jorgea3004")
                ),
                React.createElement("a", {href:"http://www.facebook.com/jorgea3004", target:"_blank"},
                  React.createElement("img", {src:"//yorch3004.xyz/public/img/social_fblogo.jpg",alt:"Facebook"})
                ),
                React.createElement("a", {href:"http://www.facebook.com/jorgea3004",className:"profession", target:"_blank"},"")
              ),
              React.createElement("div", {className:"sixths_team"},
                React.createElement("h4", {}, "Instagram",
                  React.createElement("br", {}),
                  React.createElement("span", {},"@jorgea3004")
                ),
                React.createElement("a", {href:"http://www.instagram.com/jorgea3004", target:"_blank"},
                  React.createElement("img", {src:"//yorch3004.xyz/public/img/social_instagram_2016_icon.jpg",alt:"Instagram"})
                ),
                React.createElement("a", {href:"http://www.instagram.com/jorgea3004",className:"profession", target:"_blank"},"")
              ),
              React.createElement("div", {className:"sixths_team"},
                React.createElement("h4", {}, "PlayStation",
                  React.createElement("br", {}),
                  React.createElement("span", {},"jorgea3004")
                ),
                React.createElement("a", {href:"https://my.playstation.com/jorge3004", target:"_blank"},
                  React.createElement("img", {src:"//yorch3004.xyz/public/img/social_ui_icons_mobile.jpg",alt:"PlayStation"})
                ),
                React.createElement("a", {href:"https://my.playstation.com/jorge3004",className:"profession", target:"_blank"},"")
              ),
              React.createElement("div", {className:"sixths_team"},
                React.createElement("h4", {}, "LinkedIn",
                  React.createElement("br", {}),
                  React.createElement("span", {},"jorgea3004")
                ),
                React.createElement("a", {href:"https://mx.linkedin.com/in/jorgea3004", target:"_blank"},
                  React.createElement("img", {src:"//yorch3004.xyz/public/img/social_linkedin-icon.png",alt:"linkedin"})
                ),
                React.createElement("a", {href:"https://mx.linkedin.com/in/jorgea3004",className:"profession", target:"_blank"},"")
              ),
              React.createElement("div", {className:"sixths_team"},
                React.createElement("h4", {}, "Git Hub",
                  React.createElement("br", {}),
                  React.createElement("span", {},"jorgea3004")
                ),
                React.createElement("a", {href:"/jorgea3004", target:"_blank"},
                  React.createElement("img", {src:"//yorch3004.xyz/public/img/social_github.png",alt:"Git Hub"})
                ),
                React.createElement("a", {href:"/jorgea3004",className:"profession", target:"_blank"},"")
              )
            )
          )
        )
      )
  }
}

class Galeria extends React.Component {
  state = {
      showModal: 'block',
      galerias: []
  }
  constructor(props) {
    super(props)
    this.handleClick = this.handleClick.bind(this);
  }
  handleClick(event) {
    const target = event.target;
    const value = target.id;
    const name = target.name;
    ReactDOM.render(<GaleryItem gal={value} />, document.getElementById("wapper"));
  }
  componentDidMount() {
    let self = this;
      axios.get("//yorch3004.xyz/galerias/").then(response => response.data)
        .then(function(data) {
          self.setState({galerias: data});
        })
        .catch(function(error) {
          console.log(error);
        });
  }
  
  render() {
    let self = this;
    return (
      React.createElement('div',{id:'main'},
        React.createElement('div',{id:'main_part_sect'},
          React.createElement('div',{id:'main_part_inner'},
            React.createElement('div',{id:'main_part_inner_in'},
              React.createElement('h1',{},'Mis Galerias')
            )
          ),
          React.createElement('div',{id:'content_inner'},
            React.createElement("section", {},
              React.createElement("h3", {},""),
              React.createElement("p", {className:"teamline"},""),
              React.createElement("section", {id:'galeriaFt'},''),
              React.createElement("section", {id:'galeriaBd'},
                this.state.galerias.map(function(v,i){
                  return (
                    React.createElement("div", {className:"fourths_portfolio", key:i},
                      React.createElement("h4", {}, v.title,
                        React.createElement("br", {}),
                        React.createElement("span", {},"Ver más")
                      ),
                      React.createElement("a", {href:"#"},
                        React.createElement("img", {src:"//yorch3004.xyz/public/uploads/galerias/"+v.gal+"/"+v.foto,alt:v.title, id:v.gal, name:v.title, onClick:self.handleClick})
                      )
                    )
                    )
                })
              ),
              React.createElement("hr", {className:'cleanit'}),
              React.createElement("div", {id:'pagination'},''),
              React.createElement("div", {className:'cara'},''),
              React.createElement("p", {className:'textit'},'')
            )
          )
        )
      )
    )
  }
}

class GaleryItem extends React.Component {
  state = {
      showModal: 'block',
      idGal: 0,
      nombre: '',
      elementos: [],
      paginador:0
  }
  constructor(props) {
    super(props)
    //this.handleClick = this.handleClick.bind(this);
    this.handleClick = this._handleClick.bind(this);
  }
  _handleClick(event) {
    const target = event.target;
    const foto = target.name;
    let url = "//yorch3004.xyz/public/uploads/galerias/"+this.state.idGal+"/"+foto;
    ReactDOM.render(<Modal link={url} />, document.getElementById('galeriaFt'))
    event.preventDefault();
    return false;
  }
  componentDidMount() {
    let self = this;
    axios.get("//yorch3004.xyz/galerias/detalle/"+this.props.gal).then(response => response.data)
      .then(function(data) {
        self.setState({elementos: data.items,paginador:data.pagination,idGal:self.props.gal,nombre: data.nombre});
        ReactDOM.render(
          <Paginador url={"#"} page={1} total={data.pagination} />, 
          document.getElementById("pagination")
          );
      })
      .catch(function(error) {
        console.log(error);
      });
  }
  render() {
    let self=this;
    return (
      React.createElement('div',{id:'main'},
        React.createElement('div',{id:'main_part_sect'},
          React.createElement('div',{id:'main_part_inner'},
            React.createElement('div',{id:'main_part_inner_in'},
              React.createElement('h1',{},''+this.state.nombre+'')
            )
          )
        ),
        React.createElement('div',{id:'content_inner'},
          React.createElement("section", {},
            React.createElement("h3", {},""),
            React.createElement("p", {className:"teamline"},""),
            React.createElement("section", {id:'galeriaFt'},''),
            React.createElement("section", {id:'galeriaBd'},
              this.state.elementos.map(function(v,i){
                return (
                  React.createElement("div", {className:"fourths_portfolio", key:i, onClick:self.handleClick, name:v.foto},
                    React.createElement("h4", {}, v.title,
                      React.createElement("br", {}),
                      React.createElement("span", {},"Ver más")
                    ),
                    React.createElement("a", {href:"#"},
                      React.createElement("img", {src:"//yorch3004.xyz/public/uploads/galerias/"+v.gal+"/"+v.foto,alt:v.title, id:v.gal, name:v.foto})
                    )
                  )
                  )
              })
            ),
            React.createElement("hr", {className:'cleanit'}),
            React.createElement("div", {id:'pagination'},''),
            React.createElement("div", {className:'cara'},''),
            React.createElement("p", {className:'textit'},'')
          )
        )
      )
    )
  }
}
class Paginador extends React.Component {
  state = {
    url:'',
    aditionalItems: 0,
    totalPages: 10,
    itemsPaged: 10,
    currentPage: 1,
    limit:2,
    finalArray: []
  }
  constructor(props) {
    super(props)
    this.handleClick = this.handleClick.bind(this);
  }
  handleClick(event){
      const target = event.target;
      const value = target.id;
    let elementos = this.getPaging(this.state.url,this.state.aditionalItems, this.state.totalPages,this.state.itemsPaged,value,this.state.limit);
    this.setState({currentPage:value, finalArray: elementos });
    return false;
  }
  componentDidMount() {
    this.setState({
      url: this.props.url,
      totalPages: this.props.total,
      currentPage: this.props.actual
    })
    let elementos = this.getPaging(this.state.url,this.state.aditionalItems, this.state.totalPages,this.state.itemsPaged,this.state.currentPage,this.state.limit);
    this.setState({ finalArray: elementos }); 
  }
  getPaging(url,aditionalItems, totalPages,itemsPaged,currentPage,limit) {
    let pages = new Array(),init = 1, end = 1, previousPage=[], nextPage=[], arraypg = [];
    if(totalPages <= itemsPaged) {
      for(let i=1; i<=totalPages; i++){
        pages.push(this.getPage(url,i,currentPage));
      }
    }
    else if(currentPage == 1) {
      for(let i=1; i<=itemsPaged; i++){
        pages.push(this.getPage(url,i,currentPage));
      }
      pages.push(['','...','']);
      pages.push(this.getPage(url,totalPages,currentPage));
    }
    else if(currentPage == totalPages) {
      limit = parseInt(parseInt(totalPages) - parseInt(parseInt(itemsPaged) - 1));
      pages.push(this.getPage(url,1,currentPage));
      pages.push(['','...','']);
      for(let i=limit; i<=totalPages; i++){
        pages.push([url,i,i]);
      }
    }
    else if((itemsPaged+1)==totalPages) {
      pages.push(this.getPage(url,1,currentPage));
      pages.push(['','...','']);
      for(let i=2; i<=totalPages; i++){
        pages.push([url,i,i]);
      }
    }
    else if(currentPage < totalPages && currentPage > 1) {
      aditionalItems = parseInt(itemsPaged/2);
      init = currentPage - aditionalItems;
      if(init <= 1) {
        init = 2;
        end = parseInt(itemsPaged) + 1;
      } else {
        end = parseInt(currentPage) + parseInt(aditionalItems);
      }
      if(end >= totalPages) { 
        end = parseInt(totalPages) - 1;
        init = parseInt(end) - parseInt(parseInt(itemsPaged) - 1);
      }
      pages.push(this.getPage(url,1,currentPage));
      pages.push(['','...','']);
      for(let i=(init); i<=end; i++){
        pages.push(this.getPage(url,i,currentPage));
      }
      pages.push(['','...','']);
      pages.push(this.getPage(url,totalPages,currentPage));
    }
    if(currentPage > 1){
      let urlp = url+"/"+((currentPage > 1) ? parseInt(currentPage-1) : 1);
      previousPage.push(urlp,' << ',((currentPage > 1) ? parseInt(parseInt(currentPage)-1) : 1));
    }
    if(currentPage < totalPages){
      let urln = url+'/'+((currentPage < totalPages) ? (parseInt(currentPage+1)) : totalPages);
      nextPage.push(urln,' >> ', ((currentPage < totalPages) ? (parseInt(parseInt(currentPage)+1)) : totalPages));
    }
    if (previousPage.length>0) {arraypg.push(previousPage);}
    for (var i = 0; i < pages.length; i++) {
      arraypg.push(pages[i]);
    };
    if (nextPage.length>0) {arraypg.push(nextPage);}
    return arraypg;
  }
  getPage(url,i,currentPage) {
    let element=new Array();
    if (i==currentPage) {
      element = (['', ' ['+i+'] ', '']);
    } else {
      let urlm = url+"/"+i;
      element = ([urlm, i, i]);
    }
    return (element);
  }
  render() {
    let self = this;
    return (React.createElement('ul',{className:'pagination'},
      this.state.finalArray.map(function(v,i){
        if (typeof v[0] !== undefined) {
          if (v[0].length>0) {
            return (
              React.createElement("li",{key:i},
                React.createElement("a",{id:v[2],href:'#',onClick:self.handleClick},v[1])
              )
            )
          } else {
            return (
              React.createElement("li",{key:i},v[1])
            )
          }
        }
      })
    ))
  }
}
class Modal extends React.Component {
  constructor(props) {
    super(props);
  }

  closeModal(){
   ReactDOM.render(React.createElement("section", {},''), document.getElementById('galeriaFt'))
  }

  render() {
    return (
      React.createElement("section", {className:'modalBg',id:'modalBg'},
        React.createElement("div", {className:'modal'},
          React.createElement("div", {className:'modalOff',onClick:this.closeModal},'X'),
          React.createElement("img", {id:'photoModal',src:this.props.link})
        )
      )
    )
  }
}

class Contactoclose extends React.Component {
  constructor(props) {
    super(props);
  }
  render() {
    return (
      <div>{this.props.respuesta}</div>
      )
  }
}

class Contacto extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      nombre: '',
      email: '',
      url: '',
      message: '',
      respuesta: ''
    };

    this.handleInputChange = this.handleInputChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleInputChange(event) {
    const target = event.target;
    const value = target.type === 'checkbox' ? target.checked : target.value;
    const name = target.name;
    this.setState({
      [name]: value
    });
  }

  handleSubmit() {
    let self=this;
    let datas = {
        'nombre': self.state.nombre,
        'email': self.state.email,
        'url': self.state.url,
        'message': self.state.message
        };
    axios({
        method: 'post',
        url: "http://yorch3004.xyz/contacto/validate/",
        headers: { 'content-type': 'application/json' },
        data: datas
      })
      .then(function(response) {
        self.setState({
          respuesta: response.data.message,
          frmlog: response.data.frmlog
        });
        if (response.data.frmlog==true) {
          document.getElementById('formaContacto').style.display = "none";
        } else {
        }
      })
      .catch(function(error) {
        console.log(error);
      });
  }

  render() {
    return (
      React.createElement('div',{id:'main'},
        React.createElement('div',{id:'main_part_sect'},
          React.createElement('div',{id:'main_part_in'},
            React.createElement('div',{id:'main_part_inner'},
              React.createElement('div',{id:'main_part_inner_in'},
                React.createElement('h1',{},'Contacto')
              )
            )
          )
        ),
        React.createElement("div", {id:'content_inner'},
          React.createElement("p", {className:'textit'}, this.state.respuesta),
            React.createElement("section", {id:'formaContacto'},
              React.createElement("h3", {},"Escribe un mensaje"),
              React.createElement("p", {className:"textit"},"Escribeme algo si gustas contactárme."),
              React.createElement("form", {action:"#",method:"post",className:"formit"},
                React.createElement("input", {type:"text",name:"nombre",id:"nombre",placeholder:"Tu Nombre", value:this.state.nombre, onChange:this.handleInputChange }),
                React.createElement("input", {type:"email",name:"email",id:"email",placeholder:"Tu Email", value:this.state.email, onChange:this.handleInputChange }),
                React.createElement("input", {type:"text",name:"url",id:"url",placeholder:"Tu sitio", value:this.state.url, onChange:this.handleInputChange }),
                React.createElement("textarea", {type:"text",name:"message",id:"message",placeholder:"Tu mensaje", value:this.state.message, onChange:this.handleInputChange }),
                React.createElement("input", {type:"button",name:'envia',id:"envia",value:"ENVIA",className:'button_submit', onClick:this.handleSubmit})
              ),
              React.createElement("hr", {className:'cleanit'})
            )
        )
      )
    )
  }
}

class Proyectos extends React.Component {
  render() {
    return (
      React.createElement('div',{id:'main'},
        React.createElement('div',{id:'main_part_sect'},
          React.createElement('div',{id:'main_part_in'},
            React.createElement('div',{id:'main_part_inner'},
              React.createElement('div',{id:'main_part_inner_in'},
                React.createElement('h1',{},'Proyectos')
              )
            )
          )
        ),
        React.createElement("div", {id:'content_inner'},
          React.createElement("section", {},
            React.createElement("h3", {},"Mis Proyectos"),
            React.createElement("p", {className:"teamline"},""),
            React.createElement("div", {className:"fourths_portfolio"},
              React.createElement("h4", {}, "Televisa Internacional",
                React.createElement("br", {}),
                React.createElement("span", {},"Ver sitio")
              ),
              React.createElement("a", {href:"http://www.televisainternacional.tv/", target:"_blank"},
                React.createElement("img", {src:"//yorch3004.xyz/public/img/proyectos/tvsaint.jpg",alt:"Televisa Internacional"})
              )
            ),
            React.createElement("div", {className:"fourths_portfolio"},
              React.createElement("h4", {}, "CEA",
                React.createElement("br", {}),
                React.createElement("span", {},"Ver sitio")
              ),
              React.createElement("a", {href:"http://www.ceatelevisa.com/", target:"_blank"},
                React.createElement("img", {src:"//yorch3004.xyz/public/img/proyectos/ceaicon.jpg",alt:"CEA"})
              )
            ),
            React.createElement("div", {className:"fourths_portfolio"},
              React.createElement("h4", {}, "Hablando Sola",
                React.createElement("br", {}),
                React.createElement("span", {},"Ver sitio")
              ),
              React.createElement("a", {href:"http://www2.esmas.com/hablando-sola/", target:"_blank"},
                React.createElement("img", {src:"//yorch3004.xyz/public/img/proyectos/hablandosola.jpg",alt:"Hablando Sola"})
              )
            ),
            React.createElement("div", {className:"fourths_portfolio"},
              React.createElement("h4", {}, "PlayCity",
                React.createElement("br", {}),
                React.createElement("span", {},"Ver sitio")
              ),
              React.createElement("a", {href:"http://www.playcity.com.mx/", target:"_blank"},
                React.createElement("img", {src:"//yorch3004.xyz/public/img/proyectos/playcityicon.jpg",alt:"PlayCity"})
              )
            ),
            React.createElement("div", {className:"fourths_portfolio"},
              React.createElement("h4", {}, "StandParados",
                React.createElement("br", {}),
                React.createElement("span", {},"Ver sitio")
              ),
              React.createElement("a", {href:"http://www2.esmas.com/standparados/", target:"_blank"},
                React.createElement("img", {src:"//yorch3004.xyz/public/img/proyectos/standparadosicon.jpg",alt:"StandParados"})
              )
            ),
            React.createElement("hr", {className:'cleanit'}),
            React.createElement("div", {className:'cara'},''),
            React.createElement("p", {className:'textit'},'Sólo son una muestra, en lo que sigo aprendiendo.')
          )
        )
      )
    )
  }
}

class Footer extends React.Component {
  render(){
    return (
      <div id="footer_in">
        <section>
          <a href="https://www.twitter.com/jorgea3004" target="_blank"><img src="//yorch3004.xyz/public/img/icon_twitter.png" /></a>
          <a href="https://www.facebook.com/jorgea3004" target="_blank"><img src="//yorch3004.xyz/public/img/icon_facebook.png" /></a>
          <a href="https://www.instagram.com/jorgea3004" target="_blank"><img src="//yorch3004.xyz/public/img/icon_instagram.png" /></a>
        </section>
        <span>
          Contácto&nbsp;
          <a href='mailto:jorgea3004@gmail.com'>
            GMail
          </a>
        </span>
      </div>
      )
  }
}


ReactDOM.render(
  React.createElement(
    Menu,
    null
  ),
  document.getElementById('header')
);

ReactDOM.render(
  <Footer />,
  document.getElementById('footer')
);
