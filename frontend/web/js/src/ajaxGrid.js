var ReactCSSTransitionGroup = React.addons.CSSTransitionGroup;

var CellLink = React.createClass({
    render: function(){
        return(
                <a href={this.props.href} target="_blank">{this.props.text}</a>
        );
    }
});

var AjaxGrid = React.createClass({
	loadDataFromServer: function() {
    jQuery.ajax({
	  type: 'POST',
	  data: {memberId: this.props.memberId},
      url: this.props.url,
      dataType: 'json',
      success: function(data) {
        this.setState({
			headers: data.headers,
			data: data.rows,
			dataLoading: false
		});
		if(this.props.afterDataLoad){
			this.props.afterDataLoad(data);
		}		
      }.bind(this),
      error: function(xhr, status, err) {
        console.error(this.props.url, status, err.toString());
      }.bind(this)
    });
  },
  getInitialState: function() {
    return {
		headers: [],
		rows: [],
		dataLoading: true,
	};
  },
  componentDidMount: function() {
    this.loadDataFromServer();    
  },
  render: function() {
	if(this.state.dataLoading)
	{
		return (
			<div>
			  <span><img src="/images/spinner.gif"/></span>
			</div>
		);		
	}
	else{
		var headers = this.state.headers.map(function(header){
			return(<th>{header}</th>);
		});
        var rows = '';
        if(this.state.data && this.state.data.length > 0)
        {
            rows = this.state.data.map(function(data){
                var row = data.map(function(cell){
                    if(cell && cell.type == 'link'){
                        return(<td><CellLink href={cell.href} text={cell.text}></CellLink></td>);
                    }
                    return(<td>{cell}</td>);
                });
                return(<tr>{row}</tr>);
            });
        }
		
		
		return (
            <ReactCSSTransitionGroup transitionName="fade" transitionAppear={true}>
                <table key={this.props.id} className="table table-striped table-bordered">
                    <thead>
                        <tr>
                            {headers}
                        </tr>
                    </thead>
                    <tbody>
                        {rows}
                    </tbody>
                </table>
            </ReactCSSTransitionGroup>
		)
	}
  }
});


