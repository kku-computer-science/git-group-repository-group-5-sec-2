*** Settings ***
Resource    resource.robot
Library     SeleniumLibrary

*** Test Cases ***
Test Click Nonexistent Tag Link
    Open Highlight Detail Page
    ${current_url}=    Get Location
    Run Keyword And Expect Error    *    Click Element    xpath=//a[@id='nonExistentTag']
    ${new_url}=    Get Location
    Should Be Equal    ${current_url}    ${new_url}    msg=URL should not change when clicking a nonexistent tag link
    Close Browser Session

Test Click Nonexistent Gallery Image
    Open Highlight Detail Page
    ${current_url}=    Get Location
    Run Keyword And Expect Error    *    Click Element    xpath=//img[@id='nonExistentGallery']
    ${new_url}=    Get Location
    Should Be Equal    ${current_url}    ${new_url}    msg=URL should not change when clicking a nonexistent gallery image
    Close Browser Session
