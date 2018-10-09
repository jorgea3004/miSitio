    <div id="main_part_inner">
        <div id="main_part_inner_in">
            <h1>Mis Galerias</h1>
        </div>
    </div>
    <div id="socialesTop">
            <div class="fb-share-button" data-href="<?=$urlshare?>" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=$urlshare?>&amp;src=sdkpreparse">Compartir</a></div>
            <a class="twitter-share-button" href="https://twitter.com/intent/tweet">Tweet</a>
    </div>
    <div id="content_inner"></div>
    <hr class="cleanit">
    <footer id="footer"></footer>
    <script type="text/babel" src="<?= base_url();?>public/js/mainMenu.js"></script>
    <script type="text/babel" src="<?= base_url();?>public/js/ourwork.js"></script>
    <script type="text/babel" src="<?= base_url();?>public/js/mainFooter.js"></script>
    <script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
    <script type="text/babel">
    var galeriasArray = [<?=$jsonGaleria;?>];
    class CarrouselItem extends React.Component {
      constructor(props) {
        super(props)
        this.handleClick = this._handleClick.bind(this, props.gal);
      }
      propTypes: {
        id: React.PropTypes.string.isRequired,
        gal: React.PropTypes.string.isRequired,
        foto: React.PropTypes.string.isRequired,
        title: React.PropTypes.string.isRequired
      }
      componentWillReceiveProps(nextProps) {
        this.handleClick = this._handleClick.bind(this, nextProps.gal);
      }
      _handleClick(gal, event) {
        let url = "detalle";
        window.location = url;
      }
      render() {
        return (
            React.createElement("div", {className:"fourths_portfolio", onClick:this.handleClick},
              React.createElement("h4", {}, this.props.title,
                React.createElement("br", {}),
                React.createElement("span", {},"Ver más")
              ),
              React.createElement("a", {href:"<?=base_url()?>galerias/detalle/"+this.props.gal},
                React.createElement("img", {src:"<?=base_url()?>public/uploads/galerias/"+this.props.gal+"/"+this.props.foto,alt:this.props.title})
              )
            )
        )
      }
    }
    class Paginador extends React.Component {
      render() {
        return (<ul className="pagination"><?=$paginador;?></ul>)
      }
    }
var contactItemElements = galeriasArray
  .filter(function(contact) { return contact.foto })
  .map(function(contact) { return React.createElement(CarrouselItem, contact) })
var rootElement = React.createElement('div', {}, contactItemElements);
ReactDOM.render(rootElement, document.getElementById('galeriaBd'));
ReactDOM.render(<Paginador />, document.getElementById('pagination'));
</script>