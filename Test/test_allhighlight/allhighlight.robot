*** Settings ***
Resource    resource.robot
Library     SeleniumLibrary

*** Test Cases ***
Test Open All Highlights Page
    [Documentation]    Verify that opening the All Highlights page directly loads the page and displays the header and highlight items.
    Open All Highlights Page
    Verify All Highlights Page Loaded
    Close Browser Session

Test Click Highlight Item
    [Documentation]    Verify that clicking the highlight item navigates to the highlight detail page.
    Open All Highlights Page
    Verify All Highlights Page Loaded
    Click First Highlight Item
    Verify Highlight Detail Page Loaded
    Go Back
    Close Browser Session
