<?php

	class qa_html_theme extends qa_html_theme_base
	{
		function body_content()
		{
			$this->body_prefix();
			
			$this->output('<DIV CLASS="qa-body-wrapper">', '');
			
			$this->header();
			$this->output('<DIV CLASS="qa-content-wrapper">', '');	// modxclub
			$this->sidepanel();
			$this->main();
			$this->output('</DIV> <!-- END content-wrapper -->');	// modxclub
			$this->footer();
			
			$this->output('</DIV> <!-- END body-wrapper -->');
			
			$this->body_suffix();
		}
		function search_field($search)
        {
            $this->output('<INPUT '.$search['field_tags'].' VALUE="'.@$search['value'].'" CLASS="qa-search-field" placeholder="جست و جو"/>');
        }
		function attribution()
		{
			// Please see the license at the top of this file before changing this link. Thank you.
				
			qa_html_theme_base::attribution();

			// modxclub [start] Please erase. Use this theme according to license of Question2Answer.
			$this->output(
'<div class="qa-designedby"><span>کاری از <a href="http://www.technoplis.ir" title="طراحی وب، مشاوره امنیت وب، سئو">',
'تیم طراحی وب تکنوپلیس</a> ,</span>',
'</div>',
'<div class="qa-designedby"> طراحی قالب توسط <a href="http://www.tohid.ir.tc" title="طراح وب و مشاور امنیت فریلنس">توحید ناطقیان</a></div>'

			);
			// modxclub [end]
		}
	}

/*
	Omit PHP closing tag to help avoid accidental output
*/