<?PHP

	class pn_tables{
		public $committee = 'pn_committee';
		public $cycle = 'pn_cycles';
		public $form_category = 'pn_form_category';
		public $form_leader = 'pn_form_leader';
		public $form_letter = 'pn_form_letter';
		public $form_petition = 'pn_form_petition';
		public $form_testimony = 'pn_form_testimony';
		public $form_update = 'pn_form_update';
		public $form_user = 'pn_form_user';
		public $guest_users = 'pn_guest_users';
		public $invitations = 'pn_invitations';
		public $legislators = 'pn_legislators';
		public $legs2bills = 'pn_legs2bills';
		public $legs2committee = 'pn_legs2committee';
		public $user_profile = 'pn_user_profile';
		public $bills = 'pn_bills';
		public $bills_updates = 'pn_bills_updates';
		public $apikey = '';
 
 		public function __construct($prefix){
  			foreach($this as $key => $value){
   				$this->{$key} = $prefix.$value;
  			}
 		}
	}
	$pn_tables = new pn_tables($wpdb->prefix);
	$pn_tables->apikey = "207b25d043ee40a78148b02d5aff125c";
?>