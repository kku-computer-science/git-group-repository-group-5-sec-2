*** Settings ***
Documentation     This is a test suite for invalid creating a highlight
Resource          resource.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${TITLE}             งานวิจัยดีเด่น
${DESCRIPTION}       วิทยาลัยการคอมพิวเตอร์ มข. ขอแสดงความยินดีกับ นายภูมินทร์ ดวนขันธ์ ในโอกาสได้รับรางวัล วิทยานิพนธ์ดีเด่น ประจำปี 2567
${PICTURE_PATH}      ${CURDIR}\\highlight.png
${PAPER_ID}          1

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Go To Create Highlight Page
    Go To Highlight Setting Page
    Title Should Be    Highlight Papers
    Click Highlight Create Button
    Title Should Be    Create Highlight Paper

Title Can Not Be Null
    Fill Highlight Form With Validation    ${EMPTY}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}
    Element Should Contain    xpath=//div[@class='alert alert-danger']    The title field is required.
    Title Should Be    Create Highlight Paper            
Description Can Be Null
    Fill Highlight Form With Validation    ${TITLE}    ${EMPTY}    ${PICTURE_PATH}    ${PAPER_ID}
    Title Should Be    Highlight Papers
Picture Can Be Null
    Go back to Create Highlight
    Fill Highlight Form With Validation Without Image    ${TITLE}    ${DESCRIPTION}    ${PAPER_ID}
    Title Should Be    Highlight Papers        
Paper Can Not Be Null
    Go back to Create Highlight
    Fill Highlight Form With Validation    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${EMPTY}
    Element Should Contain    xpath=//div[@class='alert alert-danger']    The paper id field is required.
    Title Should Be    Create Highlight Paper        
IsSelected Can Be Null
    Fill Highlight Form With Validation Without IsSelected    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}
    Title Should Be    Highlight Papers
    Sleep    3s
    [Teardown]    Close Browser

*** Keywords ***
Click Highlight Create Button
    Click Link    xpath=//a[@class='fw-bold btn btn-primary']  # click the create highlight button

Fill Highlight Form With Validation
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//textarea[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@name='paper_id']    ${PAPER_ID}
    Click Element    xpath=//input[@name='isSelected']            # click the isSelected checkbox
    Click Button     xpath=//button[@class='btn btn-primary']     # click the create highlight button
    Click Button     xpath=//button[@id='confirmCreateBtn']       # confirm the creation of the highlight

Fill Highlight Form With Validation Without Image
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PAPER_ID}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//textarea[@name='description']    ${DESCRIPTION}
    Select From List By Value    xpath=//select[@name='paper_id']    ${PAPER_ID}
    Click Element    xpath=//input[@name='isSelected']
    Click Button     xpath=//button[@class='btn btn-primary']
    Click Button     xpath=//button[@id='confirmCreateBtn']

Fill Highlight Form With Validation Without IsSelected
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${PAPER_ID}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//textarea[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@name='paper_id']    ${PAPER_ID}
    Click Button     xpath=//button[@class='btn btn-primary']
    Click Button     xpath=//button[@id='confirmCreateBtn']

Go back to Create Highlight
    Click Link    xpath=//a[@class='fw-bold btn btn-primary']  # click the create highlight button