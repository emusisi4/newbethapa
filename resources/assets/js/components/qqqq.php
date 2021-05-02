Branchstatement::Create([
  'branchname' => $hid,
 
  'datedone' => $currentdate,
  'statementtype' => 'Account Openning',
  'statementstatus' => 'Credit',
  'transactionamount' => 0,
  'closingbalance' => $request['openningbalance'],


    'ucret' => $userid,
  
]);
