<?php

namespace MediaWiki\Page\Hook;

use ManualLogEntry;
use MediaWiki\Page\ProperPageIdentity;
use MediaWiki\Permissions\Authority;
use MediaWiki\Revision\RevisionRecord;

/**
 * This is a hook handler interface, see docs/Hooks.md.
 * Use the hook name "PageUndeleteComplete" to register handlers implementing this interface.
 *
 * @stable to implement
 * @ingroup Hooks
 */
interface PageUndeleteCompleteHook {
	/**
	 * This hook is called after a page is undeleted.
	 *
	 * @since 1.40
	 *
	 * @param ProperPageIdentity $page Page that was undeleted.
	 * @param Authority $restorer Who undeleted the page
	 * @param string $reason Reason the page was undeleted
	 * @param RevisionRecord $restoredRev Last revision of the undeleted page
	 * @param ManualLogEntry $logEntry Log entry generated by the restoration
	 * @param int $restoredRevisionCount Number of revisions restored during the deletion
	 * @param bool $created Whether the undeletion result in a page being created
	 * @param array $restoredPageIds Array of all undeleted page IDs.
	 *        This will have multiple page IDs if there was more than one deleted page with the same page title.
	 * @return void This hook must not abort, it must return no value
	 */
	public function onPageUndeleteComplete(
		ProperPageIdentity $page,
		Authority $restorer,
		string $reason,
		RevisionRecord $restoredRev,
		ManualLogEntry $logEntry,
		int $restoredRevisionCount,
		bool $created,
		array $restoredPageIds
	): void;
}
