<?php

namespace Sigmalab\Database\Expressions;

interface ICanCompileExpression
{
	function compile(ECompilerSQL $compiler): string;
}