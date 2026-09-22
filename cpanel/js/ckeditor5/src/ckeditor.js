/**
 * @license Copyright (c) 2014-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
import { Command, Plugin } from 'ckeditor5/src/core';
import { ButtonView } from 'ckeditor5/src/ui';
import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor.js';
import Alignment from '@ckeditor/ckeditor5-alignment/src/alignment.js';
import Autoformat from '@ckeditor/ckeditor5-autoformat/src/autoformat.js';
import BlockQuote from '@ckeditor/ckeditor5-block-quote/src/blockquote.js';
import Bold from '@ckeditor/ckeditor5-basic-styles/src/bold.js';
import Essentials from '@ckeditor/ckeditor5-essentials/src/essentials.js';
import FontBackgroundColor from '@ckeditor/ckeditor5-font/src/fontbackgroundcolor.js';
import FontColor from '@ckeditor/ckeditor5-font/src/fontcolor.js';
import FontSize from '@ckeditor/ckeditor5-font/src/fontsize.js';
import Heading from '@ckeditor/ckeditor5-heading/src/heading.js';
import HorizontalLine from '@ckeditor/ckeditor5-horizontal-line/src/horizontalline.js';
import Indent from '@ckeditor/ckeditor5-indent/src/indent.js';
import Italic from '@ckeditor/ckeditor5-basic-styles/src/italic.js';
import Link from '@ckeditor/ckeditor5-link/src/link.js';
import List from '@ckeditor/ckeditor5-list/src/list.js';
import MediaEmbed from '@ckeditor/ckeditor5-media-embed/src/mediaembed.js';
import Paragraph from '@ckeditor/ckeditor5-paragraph/src/paragraph.js';
import Table from '@ckeditor/ckeditor5-table/src/table.js';
import TableToolbar from '@ckeditor/ckeditor5-table/src/tabletoolbar.js';
import TextTransformation from '@ckeditor/ckeditor5-typing/src/texttransformation.js';
import tableIcon from '@ckeditor/ckeditor5-table/theme/icons/table.svg';

class DeleteTableCommand extends Command {
	refresh() {
		const model = this.editor.model;
		const table = this._getTable( model.document.selection.getFirstPosition() );

		this.isEnabled = !!table;
	}

	execute() {
		const model = this.editor.model;
		const table = this._getTable( model.document.selection.getFirstPosition() );

		if ( !table ) {
			return;
		}

		model.change( writer => {
			writer.remove( writer.createRangeOn( table ) );
		} );
	}

	_getTable( position ) {
		let element = position.parent;

		while ( element ) {
			if ( element.is( 'element', 'table' ) ) {
				return element;
			}

			element = element.parent;
		}

		return null;
	}
}

class DeleteTable extends Plugin {
	init() {
		const editor = this.editor;

		editor.commands.add( 'deleteTable', new DeleteTableCommand( editor ) );

		editor.ui.componentFactory.add( 'deleteTable', locale => {
			const buttonView = new ButtonView( locale );

			buttonView.set( {
				label: 'Eliminar tabla',
				icon: tableIcon,
				tooltip: true
			} );

			const command = editor.commands.get( 'deleteTable' );
			buttonView.bind( 'isEnabled' ).to( command );

			buttonView.on( 'execute', () => {
				editor.execute( 'deleteTable' );
			} );

			return buttonView;
		} );
	}
}

class Editor extends ClassicEditor {}

// Plugins to include in the build.
Editor.builtinPlugins = [
	Alignment,
	Autoformat,
	BlockQuote,
	Bold,
	Essentials,
	FontBackgroundColor,
	FontColor,
	FontSize,
	Heading,
	HorizontalLine,
	Indent,
	Italic,
	Link,
	List,
	MediaEmbed,
	Paragraph,
	Table,
	TableToolbar,
	TextTransformation,
	DeleteTable
];

// Editor configuration.
Editor.defaultConfig = {
	toolbar: {
		items: [
			'heading',
			'|',
			'bold',
			'italic',
			'bulletedList',
			'numberedList',
			'|',
			'alignment',
			'outdent',
			'indent',
			'|',
			'fontColor',
			'|',
			'link',
			'insertTable',
			'deleteTable'
		]
	},
	language: 'es',
	link: {
		defaultProtocol: 'https://',
		decorators: {
			openInNewTab: {
				mode: 'manual',
				label: 'Abrir en nueva pestaña',
				defaultValue: false,
				attributes: {
					target: '_blank',
					rel: 'noopener noreferrer'
				}
			}
		}
	},
	table: {
		contentToolbar: [
			'tableColumn',
			'tableRow',
			'mergeTableCells'
		]
	}
};

export default Editor;
