var WShortText = React.createClass({
    render: function(){
        return(
            <div key={this.props.inputId+'_container'} className="questionContainer" className="form-group">
                <input type="text" key={this.props.inputId+'-data'} className="form-control" name={this.props.formName + 'Data['+this.props.inputId+']'} defaultValue={this.props.value} placeholder={this.props.inputLabel}></input>
            </div>               
        );
    }
});

var WDropdown = React.createClass({
    render: function(){
        var props = this.props;
        responses = this.props.responses.map(function(response){
            var inputId = props.formName+'_'+props.inputId+'_'+response.responseId;
			return (
                <option key={inputId} value={response.responseId}>
                    {response.responseText}
                </option>
            );
        });
        
        return(
			<div key={this.props.inputId+'_container'} className="questionContainer" className="form-group">
                <p key={this.props.inputId+'_text'} style={{display:(this.props.inputLabel)?'block':'none'}}>{this.props.inputLabel}</p>
            	<select key={this.props.formName+'Data_'+this.props.inputId} className="form-control" name={this.props.formName+'Data['+this.props.inputId+']'} defaultValue={this.props.value}>
					{responses}
				</select>
			</div>
        );
    }
});

var WDynamicRadio = React.createClass({
    render: function(){
        var props = this.props;
        var responses = [];
        if(this.props.responses)
        {
            responses = this.props.responses.map(function(response){
			return (
					<div key={'container_'+props.formName+"_"+response.responseId} className="radio">
						<label key={'label_'+props.formName+"_"+response.responseId} >
							<input type="radio" onChange={props.clickHandler} key={props.formName+"_"+response.responseId} name={props.formName+"Data["+props.inputId+"]"} checked={props.responseValue == response.responseId} value={response.responseId}>{response.responseText}</input>
						</label>
					</div>);
			});            
        }		
			
		return(
            <div key={props.formName+props.inputId+'_container'} className="questionContainer" className="form-group">
                <p key={props.inputId+'_text'}>{props.inputLabel}</p>
                <div key={props.inputId+'_container'} className="row-fluid">		
                {responses}
				</div>
            </div>               
        );
    }
});

var LookupWidget = React.createClass({
    
    render: function() {
        var options = [];
        var usStates = [{'responseId':"", 'responseText':"-- select a State --"},
        {'responseId':"AL", 'responseText':"Alabama"},
        {'responseId':"AK", 'responseText':"Alaska"},
        {'responseId':"AZ", 'responseText':"Arizona"},
        {'responseId':"AR", 'responseText':"Arkansas"},
        {'responseId':"CA", 'responseText':"California"},
        {'responseId':"CO", 'responseText':"Colorado"},
        {'responseId':"CT", 'responseText':"Connecticut"},
        {'responseId':"DE", 'responseText':"Delaware"},
        {'responseId':"DC", 'responseText':"District of Columbia"},
        {'responseId':"FL", 'responseText':"Florida"},
        {'responseId':"GA", 'responseText':"Georgia"},
        {'responseId':"HI", 'responseText':"Hawaii"},
        {'responseId':"ID", 'responseText':"Idaho"},
        {'responseId':"IL", 'responseText':"Illinois"},
        {'responseId':"IN", 'responseText':"Indiana"},
        {'responseId':"IA", 'responseText':"Iowa"},
        {'responseId':"KS", 'responseText':"Kansas"},
        {'responseId':"KY", 'responseText':"Kentucky"},
        {'responseId':"LA", 'responseText':"Louisiana"},
        {'responseId':"ME", 'responseText':"Maine"},
        {'responseId':"MT", 'responseText':"Montana"},
        {'responseId':"NE", 'responseText':"Nebraska"},
        {'responseId':"NV", 'responseText':"Nevada"},
        {'responseId':"NH", 'responseText':"New Hampshire"},
        {'responseId':"NJ", 'responseText':"New Jersey"},
        {'responseId':"NM", 'responseText':"New Mexico"},
        {'responseId':"NY", 'responseText':"New York"},
        {'responseId':"NC", 'responseText':"North Carolina"},
        {'responseId':"ND", 'responseText':"North Dakota"},
        {'responseId':"OH", 'responseText':"Ohio"},
        {'responseId':"OK", 'responseText':"Oklahoma"},
        {'responseId':"OR", 'responseText':"Oregon"},
        {'responseId':"MD", 'responseText':"Maryland"},
        {'responseId':"MA", 'responseText':"Massachusetts"},
        {'responseId':"MI", 'responseText':"Michigan"},
        {'responseId':"MN", 'responseText':"Minnesota"},
        {'responseId':"MS", 'responseText':"Mississippi"},
        {'responseId':"MO", 'responseText':"Missouri"},
        {'responseId':"PA", 'responseText':"Pennsylvania"},
        {'responseId':"RI", 'responseText':"Rhode Island"},
        {'responseId':"SC", 'responseText':"South Carolina"},
        {'responseId':"SD", 'responseText':"South Dakota"},
        {'responseId':"TN", 'responseText':"Tennessee"},
        {'responseId':"TX", 'responseText':"Texas"},
        {'responseId':"UT", 'responseText':"Utah"},
        {'responseId':"VT", 'responseText':"Vermont"},
        {'responseId':"VA", 'responseText':"Virginia"},
        {'responseId':"WA", 'responseText':"Washington"},
        {'responseId':"WV", 'responseText':"West Virginia"},
        {'responseId':"WI", 'responseText':"Wisconsin"},
        {'responseId':"WY", 'responseText':"Wyoming"}];

              
        return (
                <div key={this.props.name+"-form-container"}>
                    <form key={this.props.name+"-form"} id={this.props.name+"-form"} name={this.props.name+"-form"} onSubmit={this.props.submitHandler}>
                        <WShortText key='sch-name' inputId='school-name' inputLabel='School Name' formName={this.props.name+"-form"}/>
                        <WShortText key='sch-city' inputId='city' inputLabel='City' formName={this.props.name+"-form"}/> 
                        <WDropdown key='sch-state' inputId='state' formName={this.props.name+"-form"} responses={usStates}/> 
                        <WShortText key='sch-zipcode' inputId='zip' inputLabel='Zip Code' formName={this.props.name+"-form"}/> 
                        <WShortText key='sch-street-name' inputId='street' inputLabel='Street Address' formName={this.props.name+"-form"}/>
                        <input type="submit" disabled={this.props.ajaxLoading} ref="searchBtn" value="Search" className="btn btn-default"></input>
                    </form>                    
                </div>
        );
    }
});

/*
 * props:
 * inputId
 * schoolSearchUrl
 * schoolIdInput
 */
var SchoolSearchWidget = React.createClass({
	getInitialState: function() {
        return {
            donation: {donationType:'1', schoolName:'the Education Incentive Fund'},
            ajaxLoading: false,
            error: false,
            schools: []
        };
    },
    handleInit: function(){
        
    },
    handleSubmit: function(e){
        if(this.props.handleSubmit)
        {
            return this.props.handleSubmit(e);
        }
        else
        {
            e.preventDefault();
            this.setState(this.getInitialState);            
        }        
        return;
    },   
    handleSearchSchool:function(e){
        e.preventDefault();
        var searchData = jQuery('#'+e.target.id).serialize(); 
        
        this.setState({ajaxLoading: true, ajaxLoadingMessage: 'Searching school...'});
        jQuery.ajax({
            type: 'POST',
            url: this.props.schoolSearchUrl,
            data: searchData,
            dataType: 'json',
            success: function(data) { 
                var newState = {schools: data.schools, ajaxLoading: false};
                if(data.errors)
                {
                    newState.error = data.errors;
                }
                else
                {
                    newState.error = false;
                }
                this.setState(newState);
            }.bind(this),
            error: function(xhr, status, err){
                console.error(this.props.schoolSearchUrl, status, err.toString());
            }.bind(this)
        });
        
        return;
    },
    handleChooseSchoolClick: function(e){
        jQuery('.target-school').text(jQuery(e.target).parent().text());
        jQuery(this.props.schoolIdInput).val(e.target.value);
        jQuery(this.props.schoolNameInput).val(jQuery(e.target).parent().text());
        this.setState({donation:{donationType:'2', schoolId:e.target.value, schoolName:jQuery(e.target).parent().text()}});
    },
    
    componentDidMount: function(){
        
    },
    render: function(){
        return(                
            <div key={this.props.inputId+'_container'} className="form-group">
                <div className={"modal fade "+this.props.inputId+"-dialog"} tabIndex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-lg">
                        <div className="modal-content">
                            <div className="modal-header">
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 className="modal-title" id="myModalLabel">Search School</h4>
                            </div>
                            <div className="modal-body">
                                <p>Search and select your school of choice. You only need data in one of these fields to perform a search. If you don't find your desired school please <a href="/contact" target="_blank">contact us</a> and we will add it for you.</p>
                                <div className="well" style={{position:'relative', opacity:(this.state.ajaxLoading)?'0.5':'1'}}>
                                    <LookupWidget name='school-search' error={this.state.error} submitHandler={this.handleSearchSchool}/>
									<p key={this.props.inputId+'-school-choice-overlay'} className='text-primary' style={{position:'absolute', left:'0px', top:'40%', width:'100%', height:'100%', textAlign:'center', display:(this.state.ajaxLoading)?'block':'none'}}><img src="/images/spinner.gif"/> {this.state.ajaxLoadingMessage}</p>
                                </div>
								<div key={this.props.inputId + '_error'} className="alert-danger alert" style={{display:(this.state.error)?'':'none'}}>
									{this.state.error}
								</div> 
                                <form key={this.props.inputId+'-school-choice'} id={this.props.inputId+'-school-choice'} style={{position:'relative', opacity:(this.state.ajaxLoading)?'0.5':'1'}} onSubmit={this.handleChooseSchoolSubmit}>
                                    <WDynamicRadio key='school-choice' inputId='school-choice' formName={this.props.inputId+'-school-choice'} responses={this.state.schools} clickHandler={this.handleChooseSchoolClick} responseValue={this.state.donation.schoolId} />
									<button type="button" disabled={this.state.donation.schoolId ? false : true} className="btn btn-primary btn-lg btn-block" data-dismiss="modal" onClick={this.handleSubmit}>{(this.props.btnText) ? this.props.btnText : 'Choose School'}</button>
                                </form>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>               
        );
    }
});