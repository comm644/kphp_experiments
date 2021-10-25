<?php

namespace Sigmalab\Database\Core;

interface IObjectChanged
{
	/** shows  changed state for selected member
	 * @param string $name member name
	 * @return bool  true when member value was changed
	 */
	function isMemberChanged(string $name): bool;

	/** returns  \a true if object was changed.
	 * @return bool value , \a true if object was changed or \a false
	 */
	function isChanged(): bool;


}