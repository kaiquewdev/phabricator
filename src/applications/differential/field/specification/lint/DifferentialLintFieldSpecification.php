<?php

/*
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

final class DifferentialLintFieldSpecification
  extends DifferentialFieldSpecification {

  public function shouldAppearOnRevisionView() {
    return true;
  }

  public function renderLabelForRevisionView() {
    return 'Lint:';
  }

  public function getRequiredDiffProperties() {
    return array('arc:lint');
  }

  public function renderValueForRevisionView() {
    $diff = $this->getDiff();

    $lstar = DifferentialRevisionUpdateHistoryView::renderDiffLintStar($diff);
    $lmsg = DifferentialRevisionUpdateHistoryView::getDiffLintMessage($diff);
    $ldata = $this->getDiffProperty('arc:lint');
    $ltail = null;
    if ($ldata) {
      $ldata = igroup($ldata, 'path');
      $lint_messages = array();
      foreach ($ldata as $path => $messages) {
        $message_markup = array();
        foreach ($messages as $message) {
          $path = idx($message, 'path');
          $line = idx($message, 'line');

          $code = idx($message, 'code');
          $severity = idx($message, 'severity');

          $name = idx($message, 'name');
          $description = idx($message, 'description');

          $message_markup[] =
            '<li>'.
              '<span class="lint-severity-'.phutil_escape_html($severity).'">'.
                phutil_escape_html(ucwords($severity)).
              '</span>'.
              ' '.
              '('.phutil_escape_html($code).') '.
              phutil_escape_html($name).
              ' at line '.phutil_escape_html($line).
              '<p>'.phutil_escape_html($description).'</p>'.
            '</li>';
        }
        $lint_messages[] =
          '<li class="lint-file-block">'.
            'Lint for <strong>'.phutil_escape_html($path).'</strong>'.
            '<ul>'.implode("\n", $message_markup).'</ul>'.
          '</li>';
      }
      $ltail =
        '<div class="differential-lint-block">'.
          '<ul>'.
            implode("\n", $lint_messages).
          '</ul>'.
        '</div>';
    }

    return $lstar.' '.$lmsg.$ltail;
  }
}
