<?php
/**
 * @author Sujith Haridasan <sharidasan@owncloud.com>
 *
 * @copyright Copyright (c) 2017, ownCloud GmbH
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */


namespace OCA\DAV\MetaData;


use OC\Files\Meta\MetaVersionCollection;
use OCP\IMetaData;
use Sabre\DAV\File;

class MetaDataNode {

	private $metaVersionCollection;
	/**
	 * MetaDataNode constructor.
	 *
	 */
	public function __construct(MetaVersionCollection $metaVersionCollection) {
		$this->metaVersionCollection = $metaVersionCollection;
	}

	/**
	 * Get the fileVersion Node
	 *
	 * @param $fileName
	 * @return \OCP\Files\Node
	 */
	public function getFileVersion($fileName) {
		return $this->metaVersionCollection->get($fileName);
	}

	/**
	 * Get the name of the file
	 *
	 * @return string
	 */
	public function getName() {
		return $this->metaVersionCollection->getName();
	}

	/**
	 * Returns the content of the file version
	 *
	 * @param $fileName
	 * @return false|string
	 */
	public function getFileVersionContent($fileName) {
		$getVersion = $this->getFileVersion($fileName);
		$path = $getVersion->getPath();
		return $this->metaVersionCollection->getStorage()->file_get_contents($path);
	}

	/**
	 * Returns a list of versions (path) associated with file
	 *
	 * @param $fileName
	 * @return array
	 */
	public function getVersionsOfFile() {
		$nodeVersionList = [];
		$fileList = $this->metaVersionCollection->getDirectoryListing();

		foreach ($fileList as $file) {
			array_push($nodeVersionList, $file->getInternalPath());
		}

		return $nodeVersionList;
	}

}
