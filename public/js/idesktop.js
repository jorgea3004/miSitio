class Desktop extends React.Component {
  constructor(props) {
      super(props)
      this.state = {
          isToggleOn: false
      }
      this.openMenu = this.openMenu.bind(this);
    this.openClass = this.openClass.bind(this);
    this.editOptions = this.editOptions.bind(this);
  }

  openMenu(){
     window.open('http://localhost/misitio/desktop/admin', '_blank');
  }

  editOptions(){
      this.setState(prevState => ({
        isToggleOn: !prevState.isToggleOn
      }))
  }

  openClass(event){
    const target = event.target;
    const nombreElm = target.className;
    var docmHide = document.getElementsByClassName('apartado');
    if (typeof docmHide != 'undefined'){
        for (var i = 0; i < docmHide.length; i++) {
           docmHide[i].style.display='none';
        };
    }
    var docm = document.getElementById(nombreElm);
    if(docm != null){
      docm.style.display='block';
    }
  }
  handleChange(event) {
    this.setState({nombre: event.target.nombre});
  }

 render(){
  var inner = '';
  if(this.state.isToggleOn) {
      inner = ' sobre'
  } else {
      inner = ''
  }
  var self = this;
  return (
      React.createElement('nav', {},
        React.createElement('ul', {}, 
          React.createElement("li", {className:"home",id:"home",key:"home"},
            React.createElement("img", {src:"http://localhost/misitio/public/img/home_sm.png"})
          ),
          React.createElement("li", {className:"sttn",id:"sttn",key:"sttn"},
            React.createElement("img", {src:"http://localhost/misitio/public/img/preferences_settings.png"})
          ),
          React.createElement("li", {className:"netw"+inner, onClick:this.openMenu, id:"netw",key:"netw"},
            React.createElement("ul", {id:'netwin2',key:'netwin2'}, 
              this.props.arrayElements.map(function(desk, index) { 
                  return (
                    React.createElement("li", {id:'menu'+desk.id,className:'optn'+desk.id, name:desk.title, key:desk.id+'-'+index, ref:desk.id, onClick:self.openClass},
                      React.createElement("img", {src:'http://localhost/misitio/public/img/Close-Folder.ico'}),' '
                      ,desk.title)
                  )
              })
            )
          )
        )
      )
    );
  }
}

class MenuItem extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
          isToggleOP: false
    }
    this.openClass = this.openClass.bind(this);
  }

  openClass(event){
    const target = event.target;
    const nombreElm = target.id;
    ReactDOM.render(<ShowElm arrayElements={this.props.desk} optionElm={nombreElm} />, document.getElementById('mainDesk'));
  }
  handleChange(event) {
    this.setState({nombre: event.target.nombre});
  }
  
  render() {
    return (
      React.createElement("li", {id:'optn'+this.props.id,name:this.props.title,key:this.props.id+'-'+this.props.id, onClick:this.openClass,ref:this.props.id},
        React.createElement("img", {src:'http://localhost/misitio/public/img/Close-Folder.ico'}),' '
        ,this.props.title)
    )
  }
}
class ShowElm extends React.Component {
  constructor(props) {
      super(props)
  }
  render() {
    return (React.createElement("article", {}, this.props.optionElm) )
  }
}
class DesktopItemAA extends React.Component {
  constructor(props) {
      super(props)
  }

  render(){
    return (
      React.createElement("div", {},
        this.props.arrayElements.map(function(desk, index) { 
          return (
            React.createElement("article", {className:'apartado '+desk.title,id:'optn'+desk.id,ref:'optn'+desk.id,key:desk.id+'_'+index},
              React.createElement("fieldset", {},
                React.createElement("legend", {}, ':::: '+desk.title+' ::::'),
                React.createElement("ul", {},
                  desk.content.map(function(elem, j){
                    return (
                      React.createElement("li", {id:'li'+j, className:elem.ItemClass, key:desk.id+'-'+j},
                        React.createElement("a", {href:elem.ItemLink,target:elem.ItemTarget},
                          React.createElement("img", {src:'http://localhost/misitio/public/img/iconos_metro/'+elem.ItemImage}),
                        '')
                      )
                    )
                  })
                )
              )
            )
          )
        })
      )
    )
  }
}

ReactDOM.render(<Desktop arrayElements={desktopJson} />, document.getElementById('header'));
ReactDOM.render(<DesktopItemAA arrayElements={desktopJson} />, document.getElementById('mainDesk'));
