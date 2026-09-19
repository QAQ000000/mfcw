<?php

function assertContractContactsAccessControl($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

function methodSourceForAccessControl($source, $method)
{
	$pattern = '/(?:public|protected|private) function ' . preg_quote($method, '/') . '\\b.*?(?=\\n\\t(?:public|protected|private) function |\\n})/s';
	assertContractContactsAccessControl((bool) preg_match($pattern, $source, $matches), $method . " must exist");
	return $matches[0];
}

$root = dirname(__DIR__);
$contract = str_replace("\r\n", "\n", file_get_contents($root . "/app/home/controller/ContractController.php"));
$contacts = str_replace("\r\n", "\n", file_get_contents($root . "/app/home/controller/ContactsController.php"));

$contractCreate = methodSourceForAccessControl($contract, "contractCreate");
assertContractContactsAccessControl(strpos($contractCreate, 'where("id", $hid)->where("uid", $uid)') !== false, "contract creation must verify host ownership");
assertContractContactsAccessControl(strpos($contractCreate, 'where("contract_id", $tplid)->where("uid", $uid)') !== false, "contract cleanup must be scoped to the owner");

$contractPage = methodSourceForAccessControl($contract, "contract");
assertContractContactsAccessControl(strpos($contractPage, 'where("id", $id)->where("uid", $uid)') !== false, "contract page must verify contract ownership");
assertContractContactsAccessControl(strpos($contractPage, 'where("a.uid", $uid)') !== false, "contract page host details must verify host ownership");
assertContractContactsAccessControl(strpos($contractPage, 'where("a.uid", $uid)') < strpos($contractPage, 'replaceArg($contract["content"], $hid)'), "contract page must verify host ownership before rendering host data");

$contractSign = methodSourceForAccessControl($contract, "contractSign");
assertContractContactsAccessControl(strpos($contractSign, 'where("id", $id)->where("uid", $uid)->where("status", 2)') !== false, "contract signing must require owner and pending status");

$contractPost = methodSourceForAccessControl($contract, "contractPost");
assertContractContactsAccessControl(substr_count($contractPost, 'where("uid", $uid)') >= 2, "contract generation reads and writes must verify ownership");
assertContractContactsAccessControl(substr_count($contractPost, 'where("status", 2)') >= 2, "contract generation reads and writes must require pending status");
assertContractContactsAccessControl(strpos($contractPost, '$param["content"]') === false, "contract generation must not trust client-supplied contract content");
assertContractContactsAccessControl(strpos($contractPost, '$param["enclosure"]') === false, "contract generation must not trust a client-supplied enclosure");
assertContractContactsAccessControl(strpos($contractPost, 'buildContractPdfContent($contract, $party, $party_b)') !== false, "contract generation must build canonical content on the server");
assertContractContactsAccessControl(strpos($contractPost, 'buildContractEnclosure($host)') !== false, "contract generation must build the service enclosure on the server");
assertContractContactsAccessControl(strpos($contractPost, 'where("a.uid", $uid)') < strpos($contractPost, 'replaceArg($contract["content"], $hid)'), "contract generation must verify host ownership before rendering host data");

$contractList = methodSourceForAccessControl($contract, "contractList");
assertContractContactsAccessControl(strpos($contractList, 'where("a.uid", request()->uid)') !== false, "contract list must always use the authenticated uid");
assertContractContactsAccessControl(strpos($contractList, '$param["uid"]') === false, "contract list must not trust a supplied uid");

$contractPostMail = methodSourceForAccessControl($contract, "postPost");
assertContractContactsAccessControl(strpos($contractPostMail, 'where("id", $id)->where("uid", $uid)->whereIn("status", [1, 2])->update(["status" => 3])') !== false, "contract mailing transition must retain owner and allowed-status conditions");
assertContractContactsAccessControl(strpos($contractPostMail, 'where("id", intval($param["voucher_id"]))->where("uid", $uid)->update(') !== false, "mailing address updates must verify ownership");

$contractCancel = methodSourceForAccessControl($contract, "cancel");
assertContractContactsAccessControl(strpos($contractCancel, 'where("id", $id)->where("uid", $uid)->where("status", 2)->update(["status" => 0])') !== false, "contract cancellation must retain owner and pending-status conditions");

$contactsSave = methodSourceForAccessControl($contacts, "save");
assertContractContactsAccessControl(strpos($contactsSave, 'where("id", $cid)->where("uid", $uid)->find()') !== false, "contact edits must verify the existing owner");
assertContractContactsAccessControl(strpos($contactsSave, 'where("id", $cid)->where("uid", $uid)->update($udata)') !== false, "contact updates must retain the owner condition");

fwrite(STDOUT, "contract and contacts access-control regression checks passed" . PHP_EOL);
