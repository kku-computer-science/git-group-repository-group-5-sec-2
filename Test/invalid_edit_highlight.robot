*** Settings ***
Documentation     This is a test suite for invalid editing a highlight
Resource          resource.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${TITLE}             บทความวิจัยได้รับการตีพิมพ์ในวารสารวิชาการระดับนานาชาติ
${DESCRIPTION}       วิทยาลัยการคอมพิวเตอร์ มหาวิทยาลัยขอนแก่น ขอแสดงความยินดีกับ ศ. ดร.จักรชัย โสอินทร์ อ. ดร.ญานิกา คงโสรส อ. ดร.เพชร อิ่มทองคำ และ Mr.Chenset Kim เนื่องในโอกาสที่บทความวิจัยได้รับการตีพิมพ์ในวารสารวิชาการระดับนานาชาติ จำนวน 1 บทความวิจัย
${PICTURE_PATH}      ${CURDIR}\\highlight2.png
${Researcher_ID}     3
${PAPER_INDEX}       1
${PAPER_NOT_SELECT}  0
${IS_SELECTED}       1
${row}               1    # row number of the highlight to be edit

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Go To Edit Highlight Page
    Go To Highlight Setting Page
    Click Edit Highlight Button

Title Can Not Be Null
    Fill Highlight Form With Validation    ${EMPTY}    ${DESCRIPTION}    ${PICTURE_PATH}    ${Researcher_ID}   ${PAPER_INDEX}    ${IS_SELECTED}
    Element Should Contain    xpath=//div[@class='alert alert-danger']    The title field is required.
    Title Should Be    Edit Highlight Paper
Description Can Be Null
    Fill Highlight Form With Validation    ${TITLE}    ${EMPTY}    ${PICTURE_PATH}    ${Researcher_ID}   ${PAPER_INDEX}    ${IS_SELECTED}
    Title Should Be    Highlight Papers
Picture Can Be Null
    Click Edit Highlight Button
    Fill Highlight Form With Validation Without Image    ${TITLE}    ${DESCRIPTION}    ${Researcher_ID}   ${PAPER_INDEX}    ${IS_SELECTED}
    Title Should Be    Highlight Papers  
Researcher Can Not Be Null
    Click Edit Highlight Button
    Fill Highlight Form With Validation    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${EMPTY}   ${PAPER_INDEX}    ${IS_SELECTED}
    Title Should Be    Highlight Papers   
Paper Can Be Null
    Click Edit Highlight Button
    Fill Highlight Form With Validation    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${Researcher_ID}   ${PAPER_NOT_SELECT}    ${IS_SELECTED}
    Element Should Contain    xpath=//div[@class='alert alert-danger']    The paper id field is required.
    Title Should Be    Edit Highlight Paper        
IsSelected Can Be Null
    Fill Highlight Form With Validation Without IsSelected    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${Researcher_ID}   ${PAPER_INDEX}
    Title Should Be    Highlight Papers
    Sleep    3s
    [Teardown]    Close Browser

*** Keywords ***
Click Edit Highlight Button
    Scroll Element Into View    xpath=//tbody/tr[${row}]//a[@class='btn btn-warning btn-sm']
    Click Link         xpath=//tbody/tr[${row}]//a[@class='btn btn-warning btn-sm']
    Title Should Be    Edit Highlight Paper

Fill Highlight Form With Validation
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${Researcher_ID}   ${PAPER_INDEX}    ${IS_SELECTED}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//input[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@id='researcherSelect']    ${RESEARCHER_ID}
    Select From List By Index    xpath=//select[@id='paperSelect']    ${PAPER_INDEX}    # select the first paper
    Scroll Element Into View     xpath=//button[@class='btn btn-primary']
    Select From List By Value    xpath=//select[@name='isSelected']    ${IS_SELECTED}      # click for display highlight at the home page
    Click Button                 xpath=//button[@class='btn btn-primary']    # click the create highlight button
    Click Button                 xpath=//button[@id='confirmEditBtn']      # confirm the creation of the highlight

Fill Highlight Form With Validation Without Image
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${Researcher_ID}   ${PAPER_INDEX}    ${IS_SELECTED}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//input[@name='description']    ${DESCRIPTION}
    Select From List By Value    xpath=//select[@id='researcherSelect']    ${RESEARCHER_ID}
    Select From List By Index    xpath=//select[@id='paperSelect']    ${PAPER_INDEX}    # select the first paper
    Scroll Element Into View     xpath=//button[@class='btn btn-primary']
    Select From List By Value    xpath=//select[@name='isSelected']    ${IS_SELECTED}      # click for display highlight at the home page
    Click Button                 xpath=//button[@class='btn btn-primary']    # click the create highlight button
    Click Button                 xpath=//button[@id='confirmEditBtn']      # confirm the creation of the highlight

Fill Highlight Form With Validation Without IsSelected
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${Researcher_ID}   ${PAPER_INDEX}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//input[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@id='researcherSelect']    ${RESEARCHER_ID}
    Select From List By Index    xpath=//select[@id='paperSelect']    ${PAPER_INDEX}    # select the first paper
    Scroll Element Into View     xpath=//button[@class='btn btn-primary']
    Click Button                 xpath=//button[@class='btn btn-primary']    # click the create highlight button
    Click Button                 xpath=//button[@id='confirmEditBtn']      # confirm the creation of the highlight